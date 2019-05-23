<?php

namespace App\Acme\Models;

use App\Acme\Models\Core\CoreProduct;
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
        'id', 'first_name', 'last_name', 'gender', 'contact_number', 'email', 'preferences', 'password', 'verified', 'email_token',
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
        return [];
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

        if (!empty($params['orderBy'])) {
            $query = $query->orderBy($params['orderBy'] === 'full_name' ? 'first_name' : $params['orderBy'], $params['ascending'] ? 'ASC' : 'DESC');
        }

        return $query;
    }
}
