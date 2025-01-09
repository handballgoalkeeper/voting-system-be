<?php

namespace App\Exceptions;

use App\Enums\ErrorMessagesEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class EntityNotFoundException extends Exception implements CustomException
{
    public function __construct(
        string                  $entityName = null,
        private readonly int    $responseCode = Response::HTTP_NOT_FOUND
    )
    {
        if (is_null($entityName)) {
            $this->message = ErrorMessagesEnum::ENTITY_NOT_FOUND_EXCEPTION_DEFAULT_MESSAGE;
        }
        else {
            $this->message = "The requested entity '{$entityName}' was not found.";
        }
        parent::__construct();
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}
