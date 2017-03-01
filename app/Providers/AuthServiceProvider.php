<?php

namespace Editora\Providers;

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
        'Editora\Model' => 'Editora\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Gate::define('update-book', function ($user, $book) {
            return $user->id == $book->author->id;
        });

        \Gate::before(function ($user, $ability) {
            if( $user->isAdmin()){
                return true;
            }
        });
    }
}
