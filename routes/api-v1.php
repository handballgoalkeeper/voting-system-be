<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\ElectionTypeController;
use Illuminate\Support\Facades\Route;

const API_VERSION = 'v1.0';

Route::prefix(API_VERSION)
    ->name('api.v1.')
    ->group(function () {
        Route::prefix('/countries')
            ->name('countries.')
            ->controller(CountryController::class)
            ->group(function () {
                Route::get('/', 'findAll')->name('find_all');
                Route::get('/{countryId}', 'findOneById')
                    ->middleware([
                        'ValidateParameter:countryId,[1-9][0-9]*',
                    ])
                    ->name('find_one_by_id');
                Route::post('/', 'create')->name('create');
                Route::put('/', 'update')->name('update');
            });

        Route::prefix('/election_types')
            ->name('election_types.')
            ->controller(ElectionTypeController::class)
            ->group(function () {
                Route::get('/', 'findAll')->name('find_all');
            });
    });
