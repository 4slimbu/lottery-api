<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class UserEmailReset extends Model
{
    const UPDATED_AT = null;

    protected $table = 'user_email_resets';

    protected $fillable = [
        'email', 'token', 'created_at',
    ];
}
