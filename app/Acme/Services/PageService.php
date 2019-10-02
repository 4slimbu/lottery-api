<?php

namespace App\Acme\Services;

use App\Acme\Models\Page;
use App\Acme\Resources\PageResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class PageService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getPages($input)
    {
        if (! $this->currentUserCan('getPages')) {
            return $this->respondWithNotAllowed();
        }

        $query = Page::filter($input);

        $pages = $query->paginate($input['limit'] ?? 15);
        $pages->load('seo');
        return PageResource::collection($pages);
    }

    public function createPage($input)
    {
        if (! $this->currentUserCan('createPage')) {
            return $this->respondWithNotAllowed();
        }

        $existingPage = Page::where('slug', $input['slug'])->first();
        if (!empty($existingPage)) {
            return $this->respondWithError('Page already exists.', 'PageExistsException')->setStatusCode(400);
        }

        $page = new Page();
        $page->fill($input);

        $page->save();

        return new PageResource($page);
    }

    public function showPage($input)
    {
        if (isset($input['page_slug'])) {
            $page = Page::where('slug', $input['page_slug'])->firstOrFail();
        }

        if (isset($input['page_id'])) {
            $page = Page::where('id', $input['page_id'])->firstOrFail();
        }

        $page->load('seo');

        return new PageResource($page);
    }

    public function updatePage($input)
    {
        if (!$this->currentUserCan('updatePage')) {
            return $this->respondWithNotAllowed();
        }


        $page = Page::findOrFail($input['page_id']);
        $page->fill($input);
        $page->save();

        return new PageResource($page);
    }


    public function destroyPage($input)
    {
        if (!$this->currentUserCan('destroyPage')) {
            return $this->respondWithNotAllowed();
        }

        $page = Page::findOrFail($input['page_id']);
        $page->delete();
    }

}