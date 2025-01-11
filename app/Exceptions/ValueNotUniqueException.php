<?php

namespace App\Exceptions;

use App\Enums\ErrorMessagesEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ValueNotUniqueException extends Exception implements CustomException
{
    public function __construct(protected $message = ErrorMessagesEnum::VALUE_NOT_UNIQUE_EXCEPTION_DEFAULT->value)
    {
        parent::__construct($this->message);
    }

    public function getResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
