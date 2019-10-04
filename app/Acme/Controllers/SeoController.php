<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\SeoCreateRequest;
use App\Acme\Requests\SeoGetRequest;
use App\Acme\Requests\SeoUpdateRequest;
use App\Acme\Services\SeoService;

class SeoController extends ApiController
{
    private $seoService;
    public function __construct(SeoService $seoService)
    {
        $this->middleware('auth:api')->except('index', 'show');
        $this->seoService = $seoService;
    }

    public function index(SeoGetRequest $request)
    {
        $input = $request->getInput();
        return $this->seoService->getSeo($input);
    }

    public function save(SeoUpdateRequest $request)
    {
        $input = $request->getInput();
        return $this->seoService->saveSeo($input);
    }

    public function show($seoId)
    {
        $input['id'] = $seoId;
        return $this->seoService->showSeo($input);
    }

    public function destroy($seoId)
    {
        $input['id'] = $seoId;
        return $this->seoService->destroySeo($input);
    }

}