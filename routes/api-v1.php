<?php

use App\Enums\ErrorMessagesEnum;
use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionTypeController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

const API_VERSION = 'v1.0';

Route::prefix(API_VERSION)
    ->name('api.v1.')
    ->group(function () {
        Route::prefix('/auth')
            ->name('auth.')
            ->group(function () {
            Route::prefix('/jwt')
                ->name('jwt.')
                ->controller(JWTAuthController::class)
                ->group(function () {
                    Route::post('/login', 'login')->name('login');
                    Route::post('/register', fn() => response()->json(
                        data: [
                            'error'=> ErrorMessagesEnum::METHOD_NOT_IMPLEMENTED_DEFAULT->value
                        ],
                        status: SymphonyResponse::HTTP_NOT_IMPLEMENTED)
                    )
                        ->name('register');
                    Route::get('/refresh_token', fn() => response()->json(
                        data: [
                            'error'=> ErrorMessagesEnum::METHOD_NOT_IMPLEMENTED_DEFAULT->value
                        ],
                        status: SymphonyResponse::HTTP_NOT_IMPLEMENTED)
                    )
                        ->name('refresh_token');
                });

        });

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
                Route::get('/{electionTypeId}', 'findOneById')
                    ->middleware([
                        'ValidateParameter:electionTypeId,[1-9][0-9]*',
                    ])
                    ->name('find_one_by_id');
                Route::post('/', 'create')->name('create');
                Route::put('/', 'update')->name('update');
            });

        Route::prefix('/elections')
            ->name('elections.')
            ->controller(ElectionController::class)
            ->group(function () {
                Route::get('/', 'findAll')->name('find_all');
                Route::post('/', 'create')->name('create');
                Route::patch('/{electionId}/publish', 'publish')
                    ->middleware([
                        'ValidateParameter:electionId,[1-9][0-9]*',
                    ])
                    ->name('publish');
                Route::prefix('/{electionId}/stages')
                    ->name('elections.')
                    ->middleware([
                        'ValidateParameter:electionId,[1-9][0-9]*',
                    ])
                    ->group(function () {
                        Route::get('/', 'findAllStages')->name('find_all_stages');
                        Route::post('/', 'addStage')->name('add_stage');
                    });

            });
    });
