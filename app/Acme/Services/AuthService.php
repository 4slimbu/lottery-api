<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\UserRegisteredEvent;
use App\Acme\Events\Registration\UserVerifyEvent;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\MediaUploadTrait;
use App\Acme\Traits\PermissionTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait, MediaUploadTrait;

    public function register($input)
    {

        // If username is provided, check if username already exists
        if (isset($input['username'])) {
            $existingUser = User::where('username', $input['username'])->first();
            if (!empty($existingUser)) {
                return $this->respondWithError('Username already exists.', 'UserExistsException')->setStatusCode(400);
            }
        }

        $userInDb = User::email($input['email'])->first();

        if (!empty($userInDb)) {
            return $this->respondWithError('Email already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $loginInput = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        $input['password'] = bcrypt($input['password']);
        $input['email_token'] = str_limit( md5($input['email']. str_random()), 8, '');
        // Give 5 free games to new user
        $input['free_games'] = 5;
        $user = User::create($input);

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

        // Create Wallet for user
        $user->wallet()->create([]);

        event(new UserRegisteredEvent($user));
        return $this->login($loginInput);
    }

    public function registerAsGuest($input)
    {
        // If username is provided, check if username already exists
        if (isset($input['username'])) {
            $existingUser = User::where('username', $input['username'])->first();
            if (!empty($existingUser)) {
                return $this->respondWithError('Username already exists.', 'UserExistsException')->setStatusCode(400);
            }
        }

        $userInDb = User::email($input['email'])->first();

        if (!empty($userInDb)) {
            return $this->respondWithError('Email already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $randomPassword = $this->randomPassword();
        $loginInput = [
            'email' => $input['email'],
            'password' => $randomPassword
        ];

        $input['first_name'] = 'Guest';
        $input['password'] = bcrypt($randomPassword);
        $input['email_token'] = str_limit( md5($input['email']. str_random()), 8, '');
        // Give 5 free games to new user
        $input['free_games'] = 5;
        $user = User::create($input);

        // Assign player role to new user user
        $user->roles()->sync(3);

        // Create wallet for user
        Wallet::create([
            'user_id' => $user->id
        ]);

        event(new UserRegisteredEvent($user));
        return $this->login($loginInput);
    }

    public function login($input)
    {
        $user = User::where('email', $input['email'])->first();

        if (empty($user)) {
            return $this->respondWithError('Login and password do not match.', 'InvalidAuthenticationException')->setStatusCode(400);
        }

        if (!$token = auth()->attempt($input)) {

            if (empty($user->password)) {
                return $this->respondWithError('User has a blank password.', 'UserBlankPasswordException')->setStatusCode(400);
            }

            return $this->respondWithError('Login and password do not match.', 'InvalidAuthenticationException')->setStatusCode(400);
        }

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource(auth()->user()),
        ];
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refreshToken()
    {
        $oldToken = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($oldToken);

        return [
            'token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource(auth()->user()),
        ];
    }

    public function reSendVerificationCode()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->respondWithNotAllowed();
        }

        $email_token = str_limit( md5($user->email. str_random()), 8, '');
        $user->email_token = $email_token;
        $user->save();

        event(new UserVerifyEvent($user, $email_token));

        return $this->respondWithSuccess('Verification code sent.', 'verificationCodeSent');
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
