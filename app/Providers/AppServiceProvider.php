<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use App\Services\CountryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(abstract: CountryRepository::class, concrete: function () {
            return new CountryRepository();
        });

        $this->app->singleton(abstract: CountryService::class, concrete: function () {
            return new CountryService(
                countryRepository: $this->app->make(abstract: CountryRepository::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
