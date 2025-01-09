<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityNotFoundException;
use App\Facade\ResponseFacade;
use App\Http\Requests\CountryCreateRequest;
use App\Services\CountryService;
use Exception;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    public function __construct(
        private readonly CountryService $countryService
    )
    {
    }

    public function findAll(): JsonResponse
    {
        try {
            $countries = $this->countryService->findAll();
        }
        catch (EntityNotFoundException $exception) {
            return ResponseFacade::errorResponse(exception: $exception);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($countries);
    }
}
