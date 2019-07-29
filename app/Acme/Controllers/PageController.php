<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\PageCreateRequest;
use App\Acme\Requests\PageGetRequest;
use App\Acme\Requests\PageUpdateRequest;
use App\Acme\Services\PageService;
use Illuminate\Http\Request;

class PageController extends ApiController
{
    private $pageService;
    public function __construct(PageService $pageService)
    {
        $this->middleware('auth:api')->except('index', 'show');
        $this->pageService = $pageService;
    }

    public function index(PageGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->pageService->getPages($input);
    }

    public function create(PageCreateRequest $request)
    {
        $input = $request->getInput();
        return $this->pageService->createPage($input);
    }

    public function show($pageIdOrSlug)
    {
        if (is_numeric($pageIdOrSlug)) {
            $input['page_id'] = $pageIdOrSlug;
        } else {
            $input ['page_slug'] = $pageIdOrSlug;
        }
        return $this->pageService->showPage($input);
    }

    public function update(PageUpdateRequest $request, $pageId)
    {
        $input = $request->getInput();
        $input['page_id'] = $pageId;
        return $this->pageService->updatePage($input);
    }

    public function destroy($pageId)
    {
        $input['page_id'] = $pageId;
        return $this->pageService->destroyPage($input);
    }

}