<?php

namespace App\Dtos\Auth\JWT;

use JsonSerializable;

class TokenGroupDTO implements JsonSerializable
{
    public function __construct(
        private string $accessToken,
        private string $refreshToken
    )
    {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }


    public function jsonSerialize(): array
    {
        return [
            'accessToken' => $this->getAccessToken(),
            'refreshToken' => $this->getRefreshToken()
        ];
    }
}
