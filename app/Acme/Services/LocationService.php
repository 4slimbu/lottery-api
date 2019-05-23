<?php

namespace App\Acme\Services;

use App\Acme\Resources\Core\LocationResource;
use DB;
use App\Acme\Models\Location;
use Illuminate\Support\Collection;

class LocationService extends ApiServices
{

	public function getLocations($input) 
	{
		$query = Location::query();

		if( isset($input['type']))
		{
			$query->where('type', '=', $input['type']);
		}

		if( isset($input['label']))
		{
            return $this->findLocations($input);
		}

		if( isset($input['state_location_id']))
		{
			$query->where('state_location_id', '=', $input['state_location_id']);
		}

		$locations = $query->take(100)->get();
		return LocationResource::collection($locations);
	}

    public function findLocations($input)
    {
		$locationQuery = "SELECT  DISTINCT l.id, l.label, IF(l.type = 'SUBURB',NULL, l.type) AS type";
	    $locationQuery .= " FROM ( SELECT l.* FROM ((SELECT l.id, l.label,l.type, lt.priority, l.available_jobs, l.population_aggregated, 1 AS kw";
		$locationQuery .= " FROM core_locations l LEFT JOIN core_location_types lt ON l.type = lt.type";
		$locationQuery .= " WHERE INSTR (l.label, '".$input['label']."') > 0 AND l.id IS NOT NULL) UNION";
		$locationQuery .= " (SELECT DISTINCT la.id, la.label, la.type, lt.priority, la.available_jobs, la.population_aggregated, 0 AS kw";
		$locationQuery .= " FROM core_locations l LEFT JOIN core_locations la ON l.area_location_id = la.id LEFT JOIN core_location_types lt";
		$locationQuery .= " ON la.type = lt.type WHERE INSTR (l.label, '".$input['label']."') > 0 AND la.id IS NOT NULL)";
		$locationQuery .= " UNION (SELECT DISTINCT lr.id,lr.label,lr.type,lt.priority,lr.available_jobs,lr.population_aggregated";
		$locationQuery .= " ,0 AS kw FROM core_locations l LEFT JOIN core_locations lr ON l.region_location_id = lr.id LEFT JOIN core_location_types lt";
		$locationQuery .= " ON lr.type = lt.type WHERE INSTR (l.label, '".$input['label']."') > 0 AND lr.id IS NOT NULL)";
		$locationQuery .= " UNION (SELECT DISTINCT ls.id,ls.label,ls.type,lt.priority,ls.available_jobs,ls.population_aggregated";
		$locationQuery .= " ,0 AS kw FROM core_locations l LEFT JOIN core_locations ls ON l.state_location_id = ls.id";
		$locationQuery .= " LEFT JOIN core_location_types lt ON ls.type = lt.type WHERE INSTR (l.label, '".$input['label']."') > 0";
		$locationQuery .= " AND ls.id IS NOT NULL) UNION (SELECT DISTINCT lc.id ,lc.label,lc.type,lt.priority,lc.available_jobs,lc.population_aggregated";
		$locationQuery .= " ,0 AS kw FROM core_locations l LEFT JOIN core_locations lc ON l.country_location_id = lc.id";
		$locationQuery .= " LEFT JOIN core_location_types lt ON lc.type = lt.type WHERE INSTR (l.label, '".$input['label']."') > 0 AND lc.id IS NOT NULL)";
		$locationQuery .= " ) AS l ORDER BY l.kw DESC, l.priority ASC, l.available_jobs DESC, l.population_aggregated DESC ) AS l";

	    $locations = DB::select($locationQuery);

	    $collectionCollection = new Collection($locations);
		return LocationResource::collection($collectionCollection);

    }

}