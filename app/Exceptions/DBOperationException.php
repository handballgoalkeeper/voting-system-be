<?php

namespace App\Exceptions;

use App\Enums\ErrorMessagesEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class DBOperationException extends Exception implements CustomException
{
    public function __construct(string $message = ErrorMessagesEnum::DB_OPERATION_EXCEPTION_DEFAULT->value)
    {
        parent::__construct($message);
    }

    public function getResponseCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
