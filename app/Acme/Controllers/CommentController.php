<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\CommentShowRequest;
use App\Acme\Requests\CommentUpdateRequest;
use App\Acme\Requests\CommentCreateRequest;
use App\Acme\Requests\CommentGetRequest;

use App\Acme\Services\CommentService;

class CommentController extends ApiController
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->middleware('auth:api');
        $this->commentService = $commentService;
    }

    public function index(CommentGetRequest $request, $postId)
    {
        $input = $request->getInput();
        $input['post_id'] = $postId;
        $user = auth()->user();
        return $this->commentService->getComments($input, $user);
    }

    public function create(CommentCreateRequest $request)
    {
        $input = $request->getInput();
        $user = auth()->user();
        return $this->commentService->createComment($input, $user);
    }

    public function update(CommentUpdateRequest $request, $commentId)
    {
        $input = $request->getInput();
        $input['id'] = $commentId;
        $user = auth()->user();
        return $this->commentService->updateComment($input, $user);
    }

    public function show($commentId)
    {
        $input['id'] = $commentId;
        $user = auth()->user();
        return $this->commentService->getComment($input, $user);
    }
    
    public function destroy($commentId)
    {
        $input['id'] = $commentId;
        $user = auth()->user();
        return $this->commentService->destroyComment($input, $user);
    }

    public function myComments()
    {
        $user = auth()->user();
        return $this->commentService->getMyComments($user);
    }
}