<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\PermissionForgotPasswordEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\Permission;
use App\Acme\Models\PermissionEmailReset;
use App\Acme\Resources\Core\PermissionResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\MediaUploadTrait;
use App\Acme\Traits\PermissionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class PermissionService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait, MediaUploadTrait;

    public function getPermissions($input)
    {
        if (! $this->currentUserCan('getPermissions')) {
            return $this->respondWithNotAllowed();
        }

        $query = Permission::filter($input);

        $permissions = $query->paginate($input['limit'] ?? 15);
        return PermissionResource::collection($permissions);
    }

    public function createPermission($input)
    {
        if (! $this->currentUserCan('createPermission')) {
            return $this->respondWithNotAllowed();
        }

        $existingPermission = Permission::where('name', $input['name'])->first();
        if (!empty($existingPermission)) {
            return $this->respondWithError('Permission already exists.', 'PermissionExistsException')->setStatusCode(400);
        }

        $permission = new Permission();
        $permission->fill($input);
        $permission->save();

        return new PermissionResource($permission);
    }

    public function showPermission($input)
    {
        if (!$this->currentUserCan('getPermissions')) {
            return $this->respondWithNotAllowed();
        }

        $permission = Permission::findOrFail($input['permission_id']);
        return new PermissionResource($permission);
    }

    public function updatePermission($input)
    {
        if (! $this->currentUserCan('updatePermission')) {
            return $this->respondWithNotAllowed();
        }

        $permission = Permission::findOrFail($input['permission_id']);
        $permission->fill($input);
        $permission->save();

        return new PermissionResource($permission->fresh());
    }

    public function updateMultiplePermission($input)
    {
        if (!$this->currentUserCan('updatePermission')) {
            return $this->respondWithNotAllowed();
        }

        $permissionIds = $input['permission_ids'];
        unset($input['permission_ids']);

        Permission::whereIn('id', $permissionIds)->update($input);
    }

    public function destroyPermission($input)
    {
        if (!$this->currentUserCan('destroyPermission')) {
            return $this->respondWithNotAllowed();
        }

        $permission = Permission::findOrFail($input['permission_id']);
        $permission->delete();
    }

    public function destroyMultiplePermission($input)
    {
        if (!$this->currentUserCan('destroyPermission')) {
            return $this->respondWithNotAllowed();
        }

        Permission::whereIn('id', $input['permission_ids'])->delete();
    }

}