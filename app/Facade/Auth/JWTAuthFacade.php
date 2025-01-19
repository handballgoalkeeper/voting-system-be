<?php

namespace App\Facade\Auth;

use App\Dtos\Auth\JWT\TokenGroupDTO;
use App\Exceptions\Auth\TokenParsingFailedException;
use App\Exceptions\DBOperationException;
use App\Mappers\Auth\JWT\TokenGroupMapper;
use App\Models\RefreshTokenModel;
use App\Services\Auth\JwtAuthService;
use Carbon\Carbon;
use Random\RandomException;

class JWTAuthFacade
{
    /**
     * @param int $userId
     * @param string|null $permittedFor
     * @param array $customClaims
     * @return TokenGroupDTO
     * @throws DBOperationException
     * @throws RandomException
     * @throws TokenParsingFailedException
     */
    public static function createAccessAndRefreshTokens(
        int $userId,
        string $permittedFor = null,
        array $customClaims = []
    ): TokenGroupDTO
    {

        $tokens = [
            'accessToken' =>app(JWTAUTHService::class)->createAccessToken(
                userId: $userId,
                permittedFor: $permittedFor,
                customClaims: $customClaims
            ),
            'refreshToken' => app(JWTAuthService::class)->createRefreshToken(
                userId: $userId,
                permittedFor: $permittedFor
            )
        ];

        return TokenGroupMapper::arrayToDto($tokens);
    }
}
