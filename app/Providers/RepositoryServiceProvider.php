<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'Categories',
            'Post'
        ];
        foreach($models as $model){
            $this->app->bind(
                "App\Repositories\Contracts\\{$model}\\{$model}RepositoryInterface",
                "App\Repositories\Eloquent\\{$model}\\{$model}EloquentRepository"
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
