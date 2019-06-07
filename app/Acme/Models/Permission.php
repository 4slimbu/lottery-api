<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'core_permissions';

    protected $fillable = [
        'id', 'name', 'label'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'core_permission_role');
    }

    public function scopeFilter($query, $params)
    {
        if (!empty($params['name'])) {
            $query = $query->where('name', 'LIKE', '%' . $params['name'] . '%');
        }

        if (!empty($params['label'])) {
            $query = $query->where('label', 'LIKE', '%' . $params['label'] . '%');
        }

        if (!empty($params['orderBy'])) {
            $query = $query->orderBy($params['orderBy'], $params['ascending'] === 'true' ? 'ASC' : 'DESC');
        } else {
            $query = $query->orderBy('id', 'DESC');
        }

        return $query;
    }
}
