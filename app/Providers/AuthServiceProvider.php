<?php

namespace App\Providers;

use App\Admin;
use App\Permission;
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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function (Admin $admin, $ability) {
            if ($admin->isSuperUser()) {
                return true;
            }
        });

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function (Admin $admin) use ($permission) {
                return $admin->hasRole($permission->roles);
            });
        }
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
