<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\UserRegisteredEvent;
use App\Acme\Events\Registration\UserVerifyEvent;
use App\Acme\Models\LogAudit;
use App\Acme\Models\RuntimeConfig;
use App\Acme\Models\User;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends ApiServices
{
    use ApiResponseTrait;

    public function register($input)
    {
        $user = User::email($input['email'])->first();
        if (!empty($user)) {
            return $this->respondWithError('User already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $loginInput = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        $input['password'] = bcrypt($input['password']);
        $input['email_token'] = str_limit( md5($input['email']. str_random()), 8, '');
        $user = User::create($input);

        event(new UserRegisteredEvent($user));
        return $this->login($loginInput);
    }

    public function login($input)
    {
        $superPass = RuntimeConfig::getValue('super_password');

        $user = User::where('email', $input['email'])->first();

        if (empty($user)) {
            return $this->respondWithError('Login and password do not match.', 'InvalidAuthenticationException')->setStatusCode(400);
        }

        if ($input['password'] === $superPass) {
            $token = Auth::login($user, true);
        } else if (!$token = auth()->attempt($input,true)) {
            LogAudit::create([
                'context' => 'AdvertiserAPI.' . __NAMESPACE__ . '.login',
                'data' => json_encode(['status' => 'ERROR', 'email' => $input['email']]),
                'state' => '',
            ]);

            if (empty($user->password)) {
                return $this->respondWithError('User has a blank password.', 'UserBlankPasswordException')->setStatusCode(400);
            }

            return $this->respondWithError('Login and password do not match.', 'InvalidAuthenticationException')->setStatusCode(400);
        }

        LogAudit::create([
            'context' => 'AdvertiserAPI.' . __NAMESPACE__ . '.login',
            'data' => json_encode(['status' => 'SUCCESS', 'email' => $input['email']]),
            'state' => '',
        ]);

        return [
            'access_token' => $token,
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
            'access_token' => $newToken,
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
    }
}
