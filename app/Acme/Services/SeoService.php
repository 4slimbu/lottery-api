<?php

namespace App\Acme\Services;

use App\Acme\Models\Seo;
use App\Acme\Resources\SeoResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class SeoService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getSeo($input)
    {
        $query = Seo::filter($input);

        $pages = $query->paginate($input['limit'] ?? 15);
        return SeoResource::collection($pages);
    }

    public function showSeo($input)
    {
        if (!isset($input['id'])) {
            return $this->respondWithError('Invalid request', 'InvalidRequestException')->setStatusCode(400);
        }

        $seo = Seo::where('id', $input['id'])->firstOrFail();

        return new SeoResource($seo);
    }

    public function saveSeo($input)
    {
        if (!$this->currentUserCan('updateSeo')) {

            return $this->respondWithNotAllowed();
        }

        $seo = Seo::where('page_id', $input['page_id'])->first();
        if (empty($seo)) {
            $seo = new Seo();
        }
        $seo->fill($input);
        $seo->save();

        return new SeoResource($seo);
    }


    public function destroySeo($input)
    {
        if (!$this->currentUserCan('destroySeo')) {
            return $this->respondWithNotAllowed();
        }

        $seo = Seo::findOrFail($input['id']);
        $seo->delete();
    }

}