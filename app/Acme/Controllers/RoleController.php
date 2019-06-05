<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\RoleGetRequest;
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

    public function create( $request)
    {
        $input = $request->getInput();
        $role = auth()->role();
        return $this->roleService->createRole($input, $role);
    }

    public function show($roleId)
    {
        $input['role_id'] = $roleId;
        $role = auth()->role();
        return $this->roleService->showRole($input, $role);
    }

    public function update( $request, $roleId)
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

}