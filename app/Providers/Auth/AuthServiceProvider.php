<?php

namespace App\Providers\Auth;

use App\Repositories\Auth\UserRepository;
use App\Services\Auth\UserService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(
                userRepository: $app->make(UserRepository::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
