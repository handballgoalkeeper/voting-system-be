<?php

namespace App\Enums;

enum ErrorMessagesEnum: string
{
    case UNHANDLED_EXCEPTION = "Unhandled exception has occurred, please contact support!";
    case ENTITY_NOT_FOUND_EXCEPTION_DEFAULT_MESSAGE = "The requested entity was not found.";
    case DB_OPERATION_EXCEPTION_DEFAULT = "Something went wrong while interacting with DB.";
    case VALUE_NOT_UNIQUE_EXCEPTION_DEFAULT = "Some of the values you provided are already in use.";
    case AUTHENTICATION_FAILED_EXCEPTION_DEFAULT = "Authentication failed.";
    case PASSWORD_FORMAT_INCORRECT_DEFAULT_MESSAGE = "Password must have at least 8 characters length, " .
        "minimum one uppercase letter, " .
        "minimum one number and at least one special character.";
    case JWT_TOKEN_PARSING_EXCEPTION_DEFAULT = "Failed parsing JWT token.";
    case METHOD_NOT_IMPLEMENTED_DEFAULT = "Method is still not implemented, work in progress.";
}
