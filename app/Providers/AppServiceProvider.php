<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use App\Repositories\ElectionRepository;
use App\Repositories\ElectionStageRepository;
use App\Repositories\ElectionTypeRepository;
use App\Services\CountryService;
use App\Services\ElectionService;
use App\Services\ElectionStageService;
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

        $this->app->singleton(abstract: ElectionRepository::class, concrete: function () {
            return new ElectionRepository();
        });

        $this->app->singleton(abstract: ElectionService::class, concrete: function () {
            return new ElectionService(
                electionRepository: $this->app->make(abstract: ElectionRepository::class)
            );
        });

        $this->app->singleton(abstract: ElectionStageRepository::class, concrete: function () {
            return new ElectionStageRepository();
        });

        $this->app->singleton(abstract: ElectionStageService::class, concrete: function () {
            return new ElectionStageService(
                electionStageRepository: $this->app->make(abstract: ElectionStageRepository::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
