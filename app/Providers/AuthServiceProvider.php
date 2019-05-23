<?php

namespace App\Providers;

use App\Acme\Models\Permission;
use App\Acme\Models\Post;
use App\Acme\Models\Comment;

use App\Acme\Policies\PostPolicy;
use App\Acme\Policies\CommentPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
	protected $policies = [
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
	];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Allow admin to have all permissions
        Gate::before(function($user) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
    
}
