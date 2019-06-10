<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\Role;
use App\Acme\Models\RoleEmailReset;
use App\Acme\Resources\Core\RoleResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class RoleService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getRoles($input)
    {
        if (! $this->currentUserCan('getRoles')) {
            return $this->respondWithNotAllowed();
        }

        if ($input['with'] && $input['with'] === 'permissions') {
            $query = Role::with('permissions')->filter($input);
        } else {
            $query = Role::filter($input);
        }

        $roles = $query->paginate($input['limit'] ?? 15);
        return RoleResource::collection($roles);
    }

    public function createRole($input)
    {
        if (! $this->currentUserCan('createRole')) {
            return $this->respondWithNotAllowed();
        }

        $existingRole = Role::where('name', $input['name'])->first();
        if (!empty($existingRole)) {
            return $this->respondWithError('Role already exists.', 'RoleExistsException')->setStatusCode(400);
        }

        $role = new Role();
        $role->fill($input);

        $role->save();

        if (isset($input['permission_ids'])) {
            $role->permissions()->sync($input['permission_ids']);
        }

        $role->load('permissions');
        return new RoleResource($role);
    }

    public function showRole($input)
    {
        if (!$this->currentUserCan('getRole')) {
            return $this->respondWithNotAllowed();
        }

        $role = Role::with(['permissions'])->findOrFail($input['role_id']);
        return new RoleResource($role);
    }

    public function updateRole($input)
    {
        if (!$this->currentUserCan('updateRole')) {
            return $this->respondWithNotAllowed();
        }


        $role = Role::findOrFail($input['role_id']);
        $role->fill($input);
        $role->save();

        if (isset($input['permission_ids'])) {
            $role->permissions()->sync($input['permission_ids']);
        }

        $role->fresh();
        $role->load('permissions');
        return new RoleResource($role);
    }


    public function destroyRole($input)
    {
        if (!$this->currentUserCan('destroyRole')) {
            return $this->respondWithNotAllowed();
        }

        $role = Role::findOrFail($input['role_id']);
        $role->delete();
    }

    public function destroyMultipleRole($input)
    {
        if (!$this->currentUserCan('destroyRole')) {
            return $this->respondWithNotAllowed();
        }

        Role::whereIn('id', $input['role_ids'])->delete();
    }

}