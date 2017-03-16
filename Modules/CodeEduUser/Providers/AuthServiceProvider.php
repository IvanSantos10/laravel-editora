<?php

namespace CodeEduUser\Providers;

use CodeEduUser\Criteria\FindPermissionsResourceCriteria;
use CodeEduUser\Repositories\PermissionRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 * @package Editora\Providers
 */
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

        $permissionRepository = app(PermissionRepository::class);
        $permissionRepository->pushCriteria(new FindPermissionsResourceCriteria());
        $permissions = $permissionRepository->all();
        foreach ($permissions as $p){
            \Gate::define("{$p->name}/{$p->resource_name}", function($user) use($p){
               return $user->hasRole($p->roles);
            });
        }

    }
}
