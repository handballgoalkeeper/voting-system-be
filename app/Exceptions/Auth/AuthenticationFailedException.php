<?php

namespace App\Exceptions\Auth;

use App\Enums\ErrorMessagesEnum;
use App\Exceptions\CustomException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailedException extends Exception implements CustomException
{
    public function __construct(string $message = ErrorMessagesEnum::AUTHENTICATION_FAILED_EXCEPTION_DEFAULT->value)
    {
        parent::__construct($message);
    }

    public function getResponseCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
