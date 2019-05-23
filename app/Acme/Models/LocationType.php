<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{
    protected $table = 'core_location_types';

    public function location()
	{
		return $this->hasMany(Location::class, 'type', 'type');
	}
}