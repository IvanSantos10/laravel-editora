<?php

namespace Editora\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Editora\Repositories\CategoryRepository::class, \Editora\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\Editora\Repositories\BookRepository::class, \Editora\Repositories\BookRepositoryEloquent::class);
        $this->app->bind(\Editora\Repositories\UserRepository::class, \Editora\Repositories\UserRepositoryEloquent::class);
        //:end-bindings:
    }
}
