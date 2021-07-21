<?php

namespace App\Acme\Services;

use App\Acme\Models\Brand;
use App\Acme\Resources\BrandResource;

class MeBrandService extends ApiServices
{
    public $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function getMyBrands()
    {
//        $b = Brand::find(1);
//        dd($b->jobs()->count());
        return BrandResource::collection($this->user->brands);
    }
}