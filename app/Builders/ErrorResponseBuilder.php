<?php

namespace App\Builders;

use Illuminate\Http\JsonResponse;

class ErrorResponseBuilder
{
    private array $errors;

    public function __construct(
        private readonly int $responseCode
    )
    {
        $this->errors = [];
    }

    public function withMessage(string $message): ErrorResponseBuilder {
        $this->errors[] = $message;
        return $this;
    }

    public function build(): JsonResponse
    {
        return response()->json(data: [
            'errors' => $this->errors,
        ], status: $this->responseCode);
    }



}
