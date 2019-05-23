<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\UserForgotPasswordEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\User;
use App\Acme\Models\UserEmailReset;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class UserService extends ApiServices
{
    use ApiResponseTrait;

    public function getUsers($input, $user)
    {
        if (!$user->can('getUsers')) {
            return $this->respondWithNotAllowed();
        }

        $users = User::filter($input)->paginate($input['limit'] ?? 15);
        return UserResource::collection($users);
    }

    public function createUser($input, $user)
    {
        if (!$user->can('createUser')) {
            return $this->respondWithNotAllowed();
        }

        $existingUser = User::email($input['email'])->first();
        if (!empty($existingUser)) {
            return $this->respondWithError('User already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $user = new User();
        $user->fill($input);

        if (!empty($input['new_password'])) {
            $user->password = bcrypt($input['new_password']);
        }
        $user->save();
        return new UserResource($user);
    }

    public function showUser($input, $user)
    {
        if (!$user->can('getUser')) {
            return $this->respondWithNotAllowed();
        }

        $user = User::with(['roles'])->findOrFail($input['user_id']);
        return new UserResource($user);
    }

    public function updateUser($input, $user)
    {
        if (!$user->can('updateUser')) {
            return $this->respondWithNotAllowed();
        }

        $existingUser = User::email($input['email'])->whereNotIn('id', [$input['user_id']])->first();
        if (!empty($existingUser)) {
            return $this->respondWithError('User already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $user = User::findOrFail($input['user_id']);
        $user->fill($input);
        if (!empty($input['new_password'])) {
            $user->password = bcrypt($input['new_password']);
        }
        $user->save();
        return new UserResource($user->fresh());
    }

    public function destroyUser($input, $user)
    {
        if (!$user->can('destroyUser')) {
            return $this->respondWithNotAllowed();
        }

        $user = User::findOrFail($input['user_id']);
        $user->delete();
    }

    public function checkEmail($input)
    {
        $user = User::email($input['email'])->firstOrFail();
        
        /*
        $re_verification = empty($user->password)?true:false;

        if($input['re_verification'] == 'no') {
            $re_verification = false;
        }
        
        if($re_verification) {
            $token = Password::getRepository()->create($user);
            if (empty($token)) {
                throw new ServerErrorException();
            }
            event(new UserReVerificationPasswordEvent($user, $token));
        }*/

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
}