<?php

namespace App\Acme\Services;

use App\Acme\Models\Setting;
use App\Acme\Resources\SettingResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class SettingService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getSettings($input)
    {
        if (isset($input['with']) && $input['with'] === 'permissions') {
            $query = Setting::with('permissions')->filter($input);
        } else {
            $query = Setting::filter($input);
        }

        $settings = $query->paginate($input['limit'] ?? 15);
        return SettingResource::collection($settings);
    }

    public function createSetting($input)
    {
        if (! $this->currentUserCan('createSetting')) {
            return $this->respondWithNotAllowed();
        }

        $existingSetting = Setting::where('key', $input['key'])->first();
        if (!empty($existingSetting)) {
            return $this->respondWithError('Setting already exists.', 'SettingExistsException')->setStatusCode(400);
        }

        $setting = new Setting();
        $setting->fill($input);

        $setting->save();

        return new SettingResource($setting);
    }

    public function showSetting($input)
    {
        if (!$this->currentUserCan('getSettings')) {
            return $this->respondWithNotAllowed();
        }

        $setting = Setting::findOrFail($input['setting_id']);
        return new SettingResource($setting);
    }

    public function updateSetting($input)
    {
        if (!$this->currentUserCan('updateSetting')) {
            return $this->respondWithNotAllowed();
        }


        $setting = Setting::findOrFail($input['setting_id']);
        $setting->fill($input);
        $setting->save();

        return new SettingResource($setting);
    }


    public function destroySetting($input)
    {
        if (!$this->currentUserCan('destroySetting')) {
            return $this->respondWithNotAllowed();
        }

        $setting = Setting::findOrFail($input['setting_id']);
        $setting->delete();
    }

    public function destroyMultipleSetting($input)
    {
        if (!$this->currentUserCan('destroySetting')) {
            return $this->respondWithNotAllowed();
        }

        Setting::whereIn('id', $input['setting_ids'])->delete();
    }

}