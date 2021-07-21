<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'core_roles';

    protected $fillable = ['name', 'label'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'core_permission_role');
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function scopeFilter($query, $params)
    {
        if (!empty($params['name'])) {
            $query = $query->where(function($q) use ($params) {
                $q->where('name', 'LIKE', '%' . $params['name'] . '%');
            });
        }

        if (!empty($params['label'])) {
            $query = $query->where(function($q) use ($params) {
                $q->where('label', 'LIKE', '%' . $params['label'] . '%');
            });
        }

        return $query;
    }

}
