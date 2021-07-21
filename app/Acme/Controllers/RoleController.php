<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\RoleCreateRequest;
use App\Acme\Requests\RoleDestroyMultipleRequest;
use App\Acme\Requests\RoleGetRequest;
use App\Acme\Requests\RoleUpdateRequest;
use App\Acme\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    private $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth:api');
        $this->roleService = $roleService;
    }

    public function index(RoleGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->roleService->getRoles($input);
    }

    public function create(RoleCreateRequest $request)
    {
        $input = $request->getInput();
        return $this->roleService->createRole($input);
    }

    public function show($roleId)
    {
        $input['role_id'] = $roleId;
        return $this->roleService->showRole($input);
    }

    public function update(RoleUpdateRequest $request, $roleId)
    {
        $input = $request->getInput();
        $input['role_id'] = $roleId;
        return $this->roleService->updateRole($input);
    }

    public function destroy($roleId)
    {
        $input['role_id'] = $roleId;
        return $this->roleService->destroyRole($input);
    }

    public function destroyMultiple(RoleDestroyMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->roleService->destroyMultipleRole($input);
    }


}