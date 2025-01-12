<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class FailedConstraintException extends Exception implements CustomException
{
    public function __construct(string $message)
    {
        parent::__construct(message: $message);
    }

    public function getResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
