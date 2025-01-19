<?php

namespace App\Mappers\Auth\JWT;

use App\Dtos\Auth\JWT\TokenGroupDTO;

class TokenGroupMapper
{
    public static function arrayToDto(array $data): TokenGroupDTO
    {
        return new TokenGroupDTO(
            accessToken: $data['accessToken'],
            refreshToken: $data['refreshToken']
        );
    }
}
