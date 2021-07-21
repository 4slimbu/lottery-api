<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\SettingCreateRequest;
use App\Acme\Requests\SettingDestroyMultipleRequest;
use App\Acme\Requests\SettingGetRequest;
use App\Acme\Requests\SettingUpdateRequest;
use App\Acme\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    private $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth:api')->except('index');
        $this->dashboardService = $dashboardService;
    }

    public function getStats()
    {
        return $this->dashboardService->getStats();
    }
}