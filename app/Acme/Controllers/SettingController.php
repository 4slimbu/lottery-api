<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\SettingCreateRequest;
use App\Acme\Requests\SettingDestroyMultipleRequest;
use App\Acme\Requests\SettingGetRequest;
use App\Acme\Requests\SettingUpdateRequest;
use App\Acme\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends ApiController
{
    private $settingService;
    public function __construct(SettingService $settingService)
    {
        $this->middleware('auth:api')->except('index');
        $this->settingService = $settingService;
    }

    public function index(SettingGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->settingService->getSettings($input);
    }

    public function create(SettingCreateRequest $request)
    {
        $input = $request->getInput();
        return $this->settingService->createSetting($input);
    }

    public function show($settingId)
    {
        $input['setting_id'] = $settingId;
        return $this->settingService->showSetting($input);
    }

    public function update(SettingUpdateRequest $request, $settingId)
    {
        $input = $request->getInput();
        $input['setting_id'] = $settingId;
        return $this->settingService->updateSetting($input);
    }

    public function destroy($settingId)
    {
        $input['setting_id'] = $settingId;
        return $this->settingService->destroySetting($input);
    }

    public function destroyMultiple(SettingDestroyMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->settingService->destroyMultipleSetting($input);
    }

}