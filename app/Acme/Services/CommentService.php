<?php

namespace App\Acme\Services;

use App\Acme\Models\Comment;
use App\Acme\Models\Post;
use App\Acme\Resources\CommentResource;
use App\Acme\Traits\ApiResponseTrait;

class CommentService extends ApiServices
{
    use ApiResponseTrait;

    public function getComments($input, $user)
    {
        $post_author = Post::find($input['post_id']);
        if ($user->id === $post_author->user_id) {
            $comments = Comment::where('post_id', $input['post_id'])->get();
        } else {
            $comments = Comment::where('post_id', $input['post_id'])
                ->where('user_id', $user->id)->get();
        }

        return CommentResource::collection($comments);
    }

    public function getMyComments($user)
    {
        $comments = Comment::where('user_id', $user->id);

        $comments = $comments->paginate(10);

        return CommentResource::collection($comments);
    }

    public function createComment($input, $user)
    {
        $input['user_id'] = $user->id;
        $comment = Comment::create($input);
        return new CommentResource($comment);
    }

    public function updateComment($input, $user)
    {
        $comment = Comment::where('id', $input['id'])->firstOrFail();

        if (!$user->can('updateComment', $comment)) {
            return $this->respondWithNotAllowed();
        }

        $comment->update($input);
        return new CommentResource($comment);
    }

    public function getComment($input, $user)
    {
        $comment = Comment::where('id', $input['id'])->firstOrFail();
        return new CommentResource($comment);
    }

    public function destroyComment($input, $user)
    {
        $comment = Comment::where('id', $input['id'])->firstOrFail();
        if (!$user->can('deleteComment', $comment)) {
            return $this->respondWithNotAllowed();
        }
        $comment->delete();
    }
}