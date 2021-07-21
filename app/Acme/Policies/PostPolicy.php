<?php

namespace App\Acme\Policies;

use App\Acme\Models\User;
use App\Acme\Models\Post;

class PostPolicy
{
    public function createPost(User $user)
    {
        return true;
    }

    public function seePost(User $user, $post)
    {
        return $user->id === $post->user_id;
    }

    public function updatePost(User $user, $post)
    {
        return $user->id === $post->user_id;
    }

    public function deletePost(User $user, $post)
    {
        return $user->id === $post->user_id;
    }
}