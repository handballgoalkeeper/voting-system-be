<?php

namespace App\Http\Requests\Auth\JWT;

use App\Http\Requests\JSONRequest;
use App\Rules\Auth\PasswordFormatRule;

class LoginRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }
}
