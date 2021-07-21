<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    /**
     * @var string
     */
    protected $table = 'log_requests';

    /**
     * @var array
     */
    protected $guarded = [];
}
