<?php

namespace App\Facade;

use App\Builders\ErrorResponseBuilder;
use App\Builders\ValidationErrorResponseBuilder;
use App\Enums\ErrorMessagesEnum;
use App\Exceptions\CustomException;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFacade
{
    public static function unhandledExceptionResponse(Exception $exception): JsonResponse {
//        TODO: Run error logging
        return response()->json(data: [
            'errors' => [
                ErrorMessagesEnum::UNHANDLED_EXCEPTION
            ],
        ], status: Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    public static function errorResponse(CustomException $exception): JsonResponse
    {
        return (new ErrorResponseBuilder(
            responseCode: $exception->getResponseCode()
        ))
            ->withMessage($exception->getMessage())
            ->build();
    }

    public static function routeParameterValidationErrorResponse(string $parameterName, string $message): JsonResponse
    {
        return (new ValidationErrorResponseBuilder(
            responseCode: Response::HTTP_BAD_REQUEST
        ))
            ->withMessage(
                parameterName: $parameterName,
                message: $message
            )
            ->build();
    }
}
