<?php

namespace App\Acme\Policies;

use App\Acme\Models\User;
use App\Acme\Models\Comment;

class CommentPolicy
{
    public function createComment(User $user)
    {
        return true;
    }

    public function seeComment(User $user, $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function updateComment(User $user, $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function deleteComment(User $user, $comment)
    {
        return $user->id === $comment->user_id;
    }
}