<?php

namespace App\Providers\Auth\JWT;

use App\Repositories\Auth\JWT\RefreshTokenRepository;
use App\Services\Auth\JwtAuthService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class JwtAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Sha256::class, function ($app) {
            return new Sha256();
        });

        $this->app->singleton(Configuration::class, function ($app) {
            return Configuration::forSymmetricSigner(
                $this->app->make(Sha256::class),
                Key\InMemory::plainText(Config::get('jwt.secret'))
            );
        });

        $this->app->singleton(RefreshTokenRepository::class, function ($app) {
            return new RefreshTokenRepository();
        });
        $this->app->singleton(JwtAuthService::class, function ($app) {
            return new JwtAuthService(
                config: $this->app->make(Configuration::class),
                refreshTokenRepository:$this->app->make(RefreshTokenRepository::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
