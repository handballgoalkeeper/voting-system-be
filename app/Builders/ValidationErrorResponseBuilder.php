<?php

namespace App\Builders;

use Illuminate\Http\JsonResponse;

class ValidationErrorResponseBuilder
{
    private array $errors;

    public function __construct(
        private readonly int $responseCode
    )
    {
        $this->errors = [];
    }

    public function withMessage(string $parameterName, string $message): ValidationErrorResponseBuilder {
        $this->errors[] = [
            $parameterName => $message
        ];

        return $this;
    }

    public function build(): JsonResponse
    {
        return response()->json(data: [
            'errors' => $this->errors,
        ], status: $this->responseCode);
    }



}
