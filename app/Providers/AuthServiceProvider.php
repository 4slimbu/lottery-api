<?php

namespace App\Providers;

use App\Acme\Models\Comment;
use App\Acme\Models\Post;
use App\Acme\Policies\CommentPolicy;
use App\Acme\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
	protected $policies = [
	];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
    }

}
