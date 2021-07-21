<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'core_locations';

    public function post()
    {
        return $this->hasMany(Post::class, 'location_id');
    }
}