<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\PostShowRequest;
use App\Acme\Requests\PostUpdateRequest;
use App\Acme\Requests\PostCreateRequest;
use App\Acme\Requests\PostGetRequest;

use App\Acme\Services\PostService;

class PostController extends ApiController
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('auth:api');
        $this->postService = $postService;
    }

    public function index(PostGetRequest $request)
    {
        $input = $request->getInput();
        $user = auth()->user();
        return $this->postService->getPosts($input, $user);
    }

    public function create(PostCreateRequest $request)
    {
        $input = $request->getInput();
        $user = auth()->user();
        return $this->postService->createPost($input, $user);
    }

    public function update(PostUpdateRequest $request, $postId)
    {
        $input = $request->getInput();
        $input['id'] = $postId;
        $user = auth()->user();
        return $this->postService->updatePost($input, $user);
    }

    public function show($postId)
    {
        $input['id'] = $postId;
        $user = auth()->user();
        return $this->postService->getPost($input, $user);
    }
    
    public function destroy($postId)
    {
        $input['id'] = $postId;
        $user = auth()->user();
        return $this->postService->destroyPost($input, $user);
    }
}