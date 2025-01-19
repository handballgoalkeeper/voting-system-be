<?php

namespace App\Rules\Auth;

use App\Enums\ErrorMessagesEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordFormatRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // NOTE: Must be minimum 8 chars, minimum 1 capital letter, minimum one number, minimum 1 special character.
        $pattern = '^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$';

        if (!preg_match("/{$pattern}/", $value)) {
            $fail(ErrorMessagesEnum::PASSWORD_FORMAT_INCORRECT_DEFAULT_MESSAGE->value);
        }
    }
}
