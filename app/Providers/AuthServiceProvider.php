<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    public function registerPolicies()
    {
        Gate::define('ADMIN', function ($user){
            $role_id = DB::table('user-role')->where('user_id', $user->id)->value('role_id');
            return $role_id === 1;
        });

        Gate::define('KASIR', function ($user){
            $role_id = DB::table('user-role')->where('user_id', $user->id)->value('role_id');
            return $role_id === 2;
        });

        Gate::define('USER', function ($user){
            $role_id = DB::table('user-role')->where('user_id', $user->id)->value('role_id');
            return $role_id === 4;
        });
    }
}
