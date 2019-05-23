<?php

namespace App\Acme\Controllers;

use App\Acme\Models\User;
use App\Acme\Requests\UserForgotPasswordRequest;
use App\Acme\Requests\LoginRequest;
use App\Acme\Requests\UserResetEmailRequest;
use App\Acme\Requests\UserResetPasswordRequest;
use App\Acme\Requests\UserRegistrationRequest;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Services\AuthService;
use App\Acme\Services\UserService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends ApiController
{
    private $authService;
    private $userService;
    private $client;

    public function __construct(AuthService $authService,  UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->client = new Client();
    }

    public function register(UserRegistrationRequest $request)
    {
        $input = $request->getInput();
        return $this->authService->register($input);
    }

    public function login(LoginRequest $request)
    {
        $input = $request->getInput();
        if (isset($input['fb_token'])) {
            return $this->facebookLogin($input['fb_token']);
        }

        return $this->authService->login($input);
    }

    // TODO: refactor this code
    private function facebookLogin($fb_token)
    {
        $fb_access_token = env('FACEBOOK_APP_ID') . '|' . env('FACEBOOK_APP_SECRET');
        $verify_fb_token_url = "https://graph.facebook.com/debug_token?input_token=" . $fb_token . "&access_token=" . $fb_access_token;
        $res = $this->client->get($verify_fb_token_url);
        $res_content = $res->getBody()->getContents();

        $tokenInfo = json_decode($res_content);
        if (! ($tokenInfo->data && $tokenInfo->data->app_id && $tokenInfo->data->is_valid)) {
            return;
        }

        // Get user info
        $fb_user_info_url = "https://graph.facebook.com/v3.3/" . $tokenInfo->data->user_id . "?fields=first_name,last_name,email,gender,location&access_token=" . $fb_token;
        $res1 = $this->client->get($fb_user_info_url);
        $res1_content = $res1->getBody()->getContents();
        $userInfo = json_decode($res1_content);

        // Get profile Pic
        $fb_profile_pic_url = "https://graph.facebook.com/me/picture?type=normal&access_token=" . $fb_token;
        $res2 = $this->client->get($fb_profile_pic_url);
        $res2_content = $res2->getBody()->getContents();

        $image = $res2_content;
        $imageName = str_random(30) . '.jpeg';

        $p = Storage::disk('s3')->put('profile/' . $imageName, $image, 'public');
//        $image_url = Storage::disk()->url($imageName);

        $filePath =  'https://s3-' . config('filesystems.disks.s3.region') . '.amazonaws.com/loksewa/profile/' . $imageName;

        // Prepare register inputs
        $input = [
            'email' => $userInfo->email,
            'first_name' => $userInfo->first_name ?? null,
            'last_name' => $userInfo->last_name ?? null,
            'gender' => $userInfo->gender ?? null,
            'fb_id' => $userInfo->id,
            'location' => $userInfo->location ?? null,
            'profile_pic' => $filePath ?? null,
            'verified' => 1,
            'password' => bcrypt(md5(mt_rand(100000, 999999)))
        ];

        $user = User::where('fb_id', $userInfo->id)->first();
        if ($user) {
            $user->fill($input)->save();

            $token = Auth::login($user, true);
            return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => new UserResource(auth()->user()),
            ];
        } else {
            return $this->authService->register($input);
        }

    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function forgotPassword(UserForgotPasswordRequest $request)
    {
        $input = $request->getInput();
        return $this->userService->forgotUserPassword($input);
    }

    public function resetPassword(UserResetPasswordRequest $request)
    {
        $input = $request->getInput();
        return $this->userService->resetUserPassword($input);
    }

    public function reSendVerificationCode()
    {
        return $this->authService->reSendVerificationCode();
    }
    public function verifyEmail($token)
    {
        $input['token'] = $token;
        return $this->userService->verifyUserEmail($input);
    }

    public function resetEmail(UserResetEmailRequest $request)
    {
        $input = $request->getInput();
        return $this->userService->resetUserEmail($input);
    }

    public function refreshToken()
    {
        return $this->authService->refreshToken();
    }
}
