<?php

namespace App\Acme\Services;

use App\Acme\Events\UserUpdatedEmailEvent;
use App\Acme\Models\User;
use App\Acme\Models\UserEmailReset;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class MeService extends ApiServices
{
    use ApiResponseTrait;

    public function getMyDetails()
    {
        return new UserResource(auth()->user());
    }

    public function updateMyPreferences($input)
    {
        $user = auth()->user();
        $user->fill(["preferences" => $input['preferences']]);
        $user->save();
        return new UserResource($user);
    }

    public function updateMyDetails($input)
    {
        $user = auth()->user();
        $user->fill($input);
        $user->save();
        return new UserResource($user);
    }

    public function updateMyEmail($input)
    {
        $user = auth()->user();

        if ($user->email === $input['email']) {
            return $this->respondWithNotAllowed('You can not set your own email', 'OwnEmailNotAllowedException')->setStatusCode(400);
        }

        $checkUser = User::email($input['email'])->first();
        if (!empty($checkUser)) {
            return $this->respondWithError('User already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $token = str_random('60');

        UserEmailReset::where('user_id', $user->id)->delete();

        $user->emailReset()->create([
            'email' => $input['email'],
            'token' => $token,
        ]);

        event(new UserUpdatedEmailEvent($user, $token, $input['email']));

        return [
            'data' => [
                'token' => $token,
            ],
        ];
    }

    public function resetMyPassword($input)
    {
        $user = auth()->user();
        if (!Hash::check($input['old_password'], $user->password)) {
            return $this->respondWithError('Password does not match', 'PasswordDoesntMatchException')->setStatusCode(400);
        }

        $user->password = bcrypt($input['new_password']);
        $user->save();

        return new UserResource($user);
    }
}