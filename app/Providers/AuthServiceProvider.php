<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * 全認証／認可サービスの登録
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 管理者のみ許可
        Gate::define('admin', function($user){
            return $user->role === 1;
        });

        // manager以上のみ可
        Gate::define('manager-higher', function($user){
            return $user->role > 0 && $user->role <= 5;
        });

        // User以上可
        Gate::define('user-higher', function($user){
            return $user->role > 0 && $user->role <= 9;
        });
    }
}
