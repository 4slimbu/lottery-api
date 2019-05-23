<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class RuntimeConfig extends Model
{
   protected $table = 'runtime_config';

    public static function getValue($key)
    {
        $output = self::where('name', $key)->first();
        return !empty($output->value) ? $output->value : '';
    }
}
