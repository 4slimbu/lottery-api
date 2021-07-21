<?php

namespace App\Acme\Controllers;

use App\Acme\Services\MediaService;

class MediaController extends ApiController
{
    private $mediaService;
    public function __construct(MediaService $mediaService)
    {
        $this->middleware('auth:api');
        $this->mediaService = $mediaService;
    }

    public function getUserMediaForBrand($brandId) {
        $input['brand_id'] = $brandId;
        return $this->mediaService->getUserMediaForBrand($input);
    }
}