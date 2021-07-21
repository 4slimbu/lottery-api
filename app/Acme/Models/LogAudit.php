<?php

namespace App\Acme\Models;


use Illuminate\Database\Eloquent\Model;

class LogAudit extends Model
{

    protected $table = 'log_audit';

    protected $fillable = [
        'context', 'data', 'state',
    ];
}