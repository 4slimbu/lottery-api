<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\UserForgotPasswordEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\User;
use App\Acme\Models\UserEmailReset;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\MediaUploadTrait;
use App\Acme\Traits\PermissionTrait;
use App\Events\UserUpdateEvent;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Maatwebsite\Excel\Facades\Excel;

class UserService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait, MediaUploadTrait;

    public function getUsers($input)
    {
        if (! $this->currentUserCan('getUsers')) {
            return $this->respondWithNotAllowed();
        }

        $query = User::with('roles')->filter($input);

        $users = $query->paginate($input['limit'] ?? 15);
        return UserResource::collection($users);
    }

    public function createUser($input)
    {
        if (! $this->currentUserCan('createUser')) {
            return $this->respondWithNotAllowed();
        }

        // If username is provided, check if username already exists
        if (isset($input['username'])) {
            $existingUser = User::where('username', $input['username'])->first();
            if (!empty($existingUser)) {
                return $this->respondWithError('Username already exists.', 'UserExistsException')->setStatusCode(400);
            }
        }

        // check if email already exists
        $existingUser = User::email($input['email'])->first();
        if (!empty($existingUser)) {
            return $this->respondWithError('Email already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $user = new User();
        $user->fill($input);
        $user->save();

        // Add media to user
        if (isset($input['profile_picture'])) {
            $this->saveProfilePicture($user, $input['profile_picture']);
        }

        // Assign player role to new user user
        if ($this->currentUserCan('createRole')) {
            if ($input['role']) {
                $user->roles()->sync($input['role']);
            }
        } else {
            $user->roles()->sync(3);
        }

        return new UserResource($user);
    }

    public function showUser($input)
    {
        if (!$this->currentUserCan('getUsers')) {
            return $this->respondWithNotAllowed();
        }

        $user = User::with(['roles'])->findOrFail($input['user_id']);
        return new UserResource($user);
    }

    public function updateUser($input)
    {
        if (! $this->currentUserCan('updateUser')) {
            return $this->respondWithNotAllowed();
        }

        $user = User::findOrFail($input['user_id']);
        $user->fill($input);
        if (!empty($input['new_password'])) {
            $user->password = bcrypt($input['new_password']);
        }
        $user->save();

        // Add media to user
        if (isset($input['profile_picture'])) {
            $this->saveProfilePicture($user, $input['profile_picture']);
        }

        // Assign player role to new user user
        if ($this->currentUserCan('createRole')) {
            if (isset($input['role'])) {
                $user->roles()->sync($input['role']);
            }
        }

        // Create Wallet for user
        $user->wallet()->create([]);

        return new UserResource($user->fresh());
    }

    public function updateMultipleUser($input)
    {
        if (!$this->currentUserCan('updateUser')) {
            return $this->respondWithNotAllowed();
        }

        $userIds = $input['user_ids'];
        unset($input['user_ids']);

        if (!empty($input['new_password'])) {
            $input['password'] = bcrypt($input['new_password']);
            unset($input['new_password']);
        }

        User::whereIn('id', $userIds)->update($input);
    }

    public function destroyUser($input)
    {
        if (!$this->currentUserCan('destroyUser')) {
            return $this->respondWithNotAllowed();
        }

        $user = User::findOrFail($input['user_id']);
        $user->delete();
    }

    public function destroyMultipleUser($input)
    {
        if (!$this->currentUserCan('destroyUser')) {
            return $this->respondWithNotAllowed();
        }

        User::whereIn('id', $input['user_ids'])->delete();
    }

    public function checkEmail($input)
    {
        $user = User::email($input['email'])->firstOrFail();
        
        return [
            'first_name' => (string)$user->first_name,
            'email' => (string)$user->email
        ];
    }

    public function verifyUserEmail($input)
    {
        $user = User::where('email_token', $input['token'])->firstOrFail();
        $user->email_token = null;
        $user->verified = 1;
        $user->save();

        event(new UserUpdateEvent($user));
        return new UserResource($user);
    }

    public function resetUserPassword($input)
    {
        $user = User::email($input['email'])->firstOrFail();

        $isTokenValid = Password::getRepository()->exists($user, $input['token']);
        if (empty($isTokenValid)) {
            return $this->respondWithError('Token is not valid.', 'PasswordTokenNotValidException')->setStatusCode(400);
        }

        $user->password = bcrypt($input['password']);
        $user->setRememberToken(str_random(60));
        $user->save();

        DB::table('password_resets')->where('email', $input['email'])->delete();
    }

    public function resetUserEmail($input)
    {
        $resetEmail = UserEmailReset::where('token', $input['token'])->whereDate('created_at', '>', Carbon::now()->subHours(24)->toDateTimeString())->firstOrFail();

        $user = User::findOrFail($resetEmail->user_id);
        $user->email = $resetEmail->email;
        $user->save();

        UserEmailReset::where('user_id', $user->id)->delete();

        return new UserResource($user);
    }

    public function forgotUserPassword($input)
    {
        $user = User::email($input['email'])->firstOrFail();

        $token = Password::getRepository()->create($user);

        if (empty($token)) {
            throw new ServerErrorException();
        }

        // This is a little hack to decrease the token length
        $row = PasswordReset::where('email', $user->email)->first();
        $short_token = mt_rand(10000000, 99999999);
        $row->token = bcrypt($short_token);
        $row->save();

        event(new UserForgotPasswordEvent($user, $short_token));
    }

    public function export()
    {
//        $result =  Excel::store(new UsersExport, 'users-list.csv', null, null, [
//            'visibility' => 'private'
//        ]);

        $status = Excel::store(new UsersExport, 'public/exports/users-list.csv');

        if ($status) {
            return $this->respond([
                "data" => [
                    "download_url" => url('/storage/exports/users-list.csv')
                ]
            ])->setStatusCode(200);
        }

        return $this->respondWithError('Something went wrong.', 'UserExportFailedException')->setStatusCode(500);
    }
}