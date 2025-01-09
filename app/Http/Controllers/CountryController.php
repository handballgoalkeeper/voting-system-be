<?php

namespace App\Http\Controllers;

use App\Builders\ErrorResponseBuilder;
use App\Enums\ErrorMessagesEnum;
use App\Exceptions\EntityNotFoundException;
use App\Services\CountryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


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
            return (new ErrorResponseBuilder(
                responseCode: $exception->getResponseCode()
            ))
            ->withMessage($exception->getMessage())
            ->build();
        }
        catch (Exception) {
            return (new ErrorResponseBuilder(
                responseCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            ))
            ->withMessage(message: ErrorMessagesEnum::UNHANDLED_EXCEPTION->value)
            ->build();
        }

        return response()->json($countries);
    }
}
