<?php

namespace App\Acme\Models;

use App\Acme\Models\Core\CoreProduct;
use App\Acme\Resources\Core\UserResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    protected $table = 'core_users';

    protected $dates = [
        'deleted_at',
    ];

    protected $fillable = [
        'id', 'first_name', 'last_name', 'gender', 'contact_number', 'email',
        'password', 'verified', 'email_token',
        'profile_pic', 'fb_id', 'device_id'
    ];

    protected $casts = [
        'preferences' => 'array'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'full_name',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            "user" => new UserResource($this),
            // Assuming user can only have one role at the moment
            "permissions" => $this->roles()->first()->permissions->pluck('name'),
        ];
    }

    public function verified()
    {
        $this->verified = 1;
        $this->email_token = null;
        $this->save();
    }

    public function emailReset()
    {
        return $this->hasOne(UserEmailReset::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'core_role_user');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles);
    }

    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    
    public function getFullNameAttribute()
    {
        $output = '';
        if (!empty($this->attributes['first_name'])) {
            $output .= $this->attributes['first_name'];
        }

        if (!empty($output) && !empty($this->attributes['last_name'])) {
            $output = $output . ' ' . $this->attributes['last_name'];
        }

        return $output;
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeFilter($query, $params)
    {
        if (!empty($params['full_name'])) {
            $query = $query->where(function($q) use ($params) {
                $q->where('first_name', 'LIKE', '%' . $params['full_name'] . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $params['full_name'] . '%');
            });
        }

        if (!empty($params['email'])) {
            $query = $query->where('email', 'LIKE', '%' . $params['email'] . '%');
        }

        if (!empty($params['is_active'])) {
            $is_active = '';

            if (strpos('active', strtolower($params['is_active'])) === 0) {
                if (empty($is_active)) {
                    $is_active = 1;
                }
            }

            if (strpos('inactive', strtolower($params['is_active'])) === 0) {
                if (empty($is_active)) {
                    $is_active = 0;
                }
            }



            if ($is_active === 1 || $is_active === 0) {
                $query = $query->where('is_active', $is_active);
            }
        }

        if (!empty($params['roles'])) {
            $query = $query->whereHas('roles', function ($q) use ($params) {
                 $q->where('label', 'LIKE', '%' . $params['roles'] . '%');
            });
        }

        if (!empty($params['orderBy'])) {
            if ($params['orderBy'] === "roles") {
                $query = $query->leftJoin('core_role_user', 'core_role_user.user_id', '=', 'core_users.id')
                    ->leftJoin('core_roles', 'core_roles.id', '=', 'core_role_user.role_id')
                    ->select('core_users.*', 'core_roles.label as user_role')
                    ->orderBy('user_role', $params['ascending'] === 'true' ? 'ASC' : 'DESC');
            } else {
                $query = $query->orderBy($params['orderBy'] === 'full_name' ? 'first_name' : $params['orderBy'], $params['ascending'] === 'true' ? 'ASC' : 'DESC');
            }
        }

        return $query;
    }

}
