<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\JSONRequest;
use App\Rules\Auth\PasswordFormatRule;

class RegisterRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'string', new PasswordFormatRule()],
        ];
    }
}
