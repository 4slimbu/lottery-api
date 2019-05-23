<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    const UPDATED_AT = null;

    protected $table = 'password_resets';

    protected $fillable = [
        'email', 'token', 'created_at',
    ];
}
