<?php

namespace App\Mappers\Auth;

use App\Dtos\Auth\UserDTO;
use App\Models\User;

class UserMapper
{
    public static function modelToDto(User $model): UserDTO
    {
        return new UserDTO(
            id: $model->getAttribute('id'),
            name: $model->getAttribute('name'),
            email: $model->getAttribute('email'),
            password: $model->getAttribute('password')
        );
    }
}
