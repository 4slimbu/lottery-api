<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'core_permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'core_permission_role');
    }
}
