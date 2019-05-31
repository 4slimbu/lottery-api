<?php

namespace App\Acme\Traits;

trait PermissionTrait
{
    /**
     * Checks if user satisfy at least one of the given permission
     *
     * This function assumes that the app is using jwt as auth driver and compares the given permission
     * with the permissions defined on the jwt token with custom claim : permissions (array)
     *
     * @param $permissions : can be string for single permission or array for multiple permissions
     * @return mixed
     */
    public function currentUserCan($permissions)
    {
        $hasPermission = false;
        $permissions = ! is_array($permissions) ? [$permissions] : $permissions;

        foreach ($permissions as $permission) {
            if (in_array($permission, auth()->payload()->get('permissions'))) {
                $hasPermission = true;
            }
        }

        return $hasPermission;
    }

    /**
     * Checks if user satisfy all one of the given permission
     *
     * This function assumes that the app is using jwt as auth driver and compares the given permission
     * with the permissions defined on the jwt token with custom claim : permissions (array)
     *
     * @param $permissions : can be string for single permission or array for multiple permissions
     * @return mixed
     */
    public function currentUserCanDoAllOf($permissions)
    {
        $hasPermission = false;
        $permissions = ! is_array($permissions) ? [$permissions] : $permissions;

        foreach ($permissions as $permission) {
            if (! in_array($permission, auth()->payload()->get('permissions'))) {
                $hasPermission = false;

                return $hasPermission;
            }

            $hasPermission = true;
        }


        return $hasPermission;
    }

}