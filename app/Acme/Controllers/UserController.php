<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\UserCreateRequest;
use App\Acme\Requests\UserGetRequest;
use App\Acme\Requests\UserUpdateRequest;
use App\Acme\Services\UserService;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api')->except('checkEmail');
        $this->userService = $userService;
    }

    public function index(UserGetRequest $request)
    {
        $input = $request->getFilter();
        $user = auth()->user();
        return $this->userService->getUsers($input, $user);
    }

    public function create(UserCreateRequest $request)
    {
        $input = $request->getInput();
        $user = auth()->user();
        return $this->userService->createUser($input, $user);
    }

    public function show($userId)
    {
        $input['user_id'] = $userId;
        $user = auth()->user();
        return $this->userService->showUser($input, $user);
    }

    public function update(UserUpdateRequest $request, $userId)
    {
        $input = $request->getInput();
        $input['user_id'] = $userId;
        $user = auth()->user();
        return $this->userService->updateUser($input, $user);
    }

    public function destroy($userId)
    {
        $input['user_id'] = $userId;
        $user = auth()->user();
        return $this->userService->destroyUser($input, $user);
    }

    public function checkEmail(Request $request)
    {
        $input['email'] = $request->email;
        return $this->userService->checkEmail($input);
    }
}