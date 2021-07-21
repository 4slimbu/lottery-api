<?php

namespace App\Acme\Controllers;

use App\Acme\Services\LocationService;
use App\Acme\Requests\Location\FindLocationRequest;
use App\Acme\Requests\Location\LocationRequest;


class LocationController extends ApiController
{
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->middleware('auth:api');
        $this->locationService = $locationService;
    }

    public function index(LocationRequest $request)
    {
        return $this->locationService->getLocations($request);
    }

    public function findLocations(FindLocationRequest $request)
    {
        return $this->locationService->findLocations($request);
    }

}