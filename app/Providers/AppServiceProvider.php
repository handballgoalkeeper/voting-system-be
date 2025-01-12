<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use App\Repositories\ElectionTypeRepository;
use App\Services\CountryService;
use App\Services\ElectionTypeService;
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

        $this->app->singleton(abstract: ElectionTypeRepository::class, concrete: function () {
            return new ElectionTypeRepository();
        });

        $this->app->singleton(abstract: ElectionTypeService::class, concrete: function () {
            return new ElectionTypeService(
                electionTypeRepository: $this->app->make(abstract: ElectionTypeRepository::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
