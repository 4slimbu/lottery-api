<?php

namespace App\Acme\Services;
use App\Acme\Resources\BrandMediaResource;
use App\Acme\Models\Media;

class MediaService extends ApiServices
{

    private $brandMediaTypeId = 6;

    public function getUserMediaForBrand($input)
    {
        //select * from core_media where (brand_id=4622  and  media_type_id = 1) or (media_type_id = 6 and user_id = 412)
        $user = auth()->user();
        $media = Media::where('brand_id', '=', $input['brand_id'])
                    ->where('user_id', '=', $user->id)
                    ->where('media_type_id', '=', $this->brandMediaTypeId)
                    ->get();

        return BrandMediaResource::collection($media);
    }
}