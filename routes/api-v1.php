<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

const API_VERSION = 'v1.0';

Route::prefix(API_VERSION)
    ->name('api.v1.')
    ->group(function () {
        Route::prefix('/countries')
            ->name('countries.')
            ->controller(CountryController::class)
            ->group(function () {
                Route::get('/', 'findAll')->name('findAll');
            });
    });
