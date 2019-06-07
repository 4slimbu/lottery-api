<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\PermissionCreateRequest;
use App\Acme\Requests\PermissionDestroyMultipleRequest;
use App\Acme\Requests\PermissionGetRequest;
use App\Acme\Requests\PermissionUpdateMultipleRequest;
use App\Acme\Requests\PermissionUpdateRequest;
use App\Acme\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends ApiController
{
    private $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->middleware('auth:api')->except('checkEmail');
        $this->permissionService = $permissionService;
    }

    public function index(PermissionGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->permissionService->getPermissions($input);
    }

    public function create(PermissionCreateRequest $request)
    {
        $input = $request->getInput();
        return $this->permissionService->createPermission($input);
    }

    public function show($permissionId)
    {
        $input['permission_id'] = $permissionId;
        return $this->permissionService->showPermission($input);
    }

    public function update(PermissionUpdateRequest $request, $permissionId)
    {
        $input = $request->getInput();
        $input['permission_id'] = $permissionId;
        return $this->permissionService->updatePermission($input);
    }

    public function updateMultiple(PermissionUpdateMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->permissionService->updateMultiplePermission($input);
    }

    public function destroy($permissionId)
    {
        $input['permission_id'] = $permissionId;
        return $this->permissionService->destroyPermission($input);
    }

    public function destroyMultiple(PermissionDestroyMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->permissionService->destroyMultiplePermission($input);
    }

}