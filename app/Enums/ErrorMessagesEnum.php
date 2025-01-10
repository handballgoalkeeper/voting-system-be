<?php

namespace App\Enums;

enum ErrorMessagesEnum: string
{
    case UNHANDLED_EXCEPTION = "Unhandled exception has occurred, please contact support!";
    case ENTITY_NOT_FOUND_EXCEPTION_DEFAULT_MESSAGE = "The requested entity was not found.";

    case DB_OPERATION_EXCEPTION_DEFAULT = "Something went wrong while interacting with DB.";
}
