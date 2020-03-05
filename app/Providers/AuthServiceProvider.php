<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Post;
use App\Policies\Admin\CategoryPolicy;
use App\Policies\Admin\PostPolicy;
use App\Policies\Admin\CommentPolicy;
use App\Policies\Admin\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        \App\Models\Categories::class => CategoryPolicy::class,
        \App\Models\User::class => UserPolicy::class,
        \App\Models\Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
//        config()->set('auth.defaults.guard', 'admin');
        $this->registerPolicies();

//        Gate::resource('posts', 'App\Policies\Admin\PoastPolicy');
        Gate::define('isAdmin', function(Admin $user){
            if($user->fullPermission()){
                return true;
            }
        });

        Gate::define('fullPost', function(Admin $user){
            if($user->hasAccess(['posts.*'])){
                return true;
            }
        });
        Gate::define('fullCategory', function(Admin $user){
            if($user->hasAccess(['category.*'])){
                return true;
            }
        });

        Gate::define('fullUser', function(Admin $user){
            if($user->hasAccess(['users.*'])){
                return true;
            }
        });
    }
}
