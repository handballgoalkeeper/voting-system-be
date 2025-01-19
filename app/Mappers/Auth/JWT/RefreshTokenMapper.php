<?php

namespace App\Mappers\Auth\JWT;

use App\Exceptions\Auth\TokenParsingFailedException;
use App\Models\RefreshTokenModel;
use App\Services\Auth\JwtAuthService;

class RefreshTokenMapper
{
    /**
     * @throws TokenParsingFailedException
     */
    public static function tokenToModel(string $token): RefreshTokenModel
    {
        $parsedToken = app(JwtAuthService::class)->parseTokenToArray($token);
        return new RefreshTokenModel([
            'user_id' => $parsedToken['sub'],
            'refresh_token' => $token,
            'issued_at' => $parsedToken['iat'],
            'expires_at' => $parsedToken['exp']
        ]);
    }
}
