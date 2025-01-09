<?php

use Illuminate\Support\Facades\Route;

const API_VERSION = 'v1.0';

Route::prefix(API_VERSION)
    ->name('api.v1.')
    ->group(function () {
        Route::prefix('/countries')
            ->name('countries.')
            ->group(function () {
                Route::get('/', fn() => response()->json(['test' => 12333]))->name('index');
            });
    });
