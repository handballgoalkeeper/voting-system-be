<?php

namespace App\Enums;

enum ErrorMessagesEnum: string
{
    case UNHANDLED_EXCEPTION = "Unhandled exception has occurred, please contact support!";
    case ENTITY_NOT_FOUND_EXCEPTION_DEFAULT_MESSAGE = "The requested entity was not found.";
}
