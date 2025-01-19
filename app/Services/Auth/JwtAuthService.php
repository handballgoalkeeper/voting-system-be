<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\TokenParsingFailedException;
use App\Exceptions\DBOperationException;
use App\Mappers\Auth\JWT\RefreshTokenMapper;
use App\Repositories\Auth\JWT\RefreshTokenRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Lcobucci\JWT\Configuration;
use Random\RandomException;

readonly class JwtAuthService
{
    public function __construct(
        protected Configuration $config,
        private RefreshTokenRepository $refreshTokenRepository,
    ) {}

    /**
     * @throws RandomException
     */
    public function createAccessToken(
        int $userId,
        string $permittedFor = null,
        array $customClaims = []
    ): string
    {
        $now = Carbon::now();

        $expiresAt = $now->copy()
            ->addMinutes(
                Config::get('jwt.token_ttl')
            );
        $canBeUsedAfter = $now->copy()->addSeconds(2);
        $permittedFor = $permittedFor ?? Config::get('app.url');

        $token = $this->config->builder()
            ->issuedBy(Config::get('app.url'))
            ->permittedFor($permittedFor)
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->issuedAt($now->toDateTimeImmutable())
            ->expiresAt($expiresAt->toDateTimeImmutable())
            ->canOnlyBeUsedAfter($canBeUsedAfter->toDateTimeImmutable())
            ->relatedTo($userId);


        foreach ($customClaims as $key => $value) {
            $token = $token->withClaim($key, $value);
        }

        $token = $token->getToken($this->config->signer(), $this->config->signingKey());

        return $token->toString();
    }

    /**
     * @throws RandomException|DBOperationException
     * @throws TokenParsingFailedException
     */
    public function createRefreshToken(
        int $userId,
        string $permittedFor = null
    ): string
    {
        $now = Carbon::now();
        $expiresAt = $now->copy()
            ->addMinutes(
                Config::get('jwt.refresh_ttl')
            );
        $canBeUsedAfter = $now->copy()->addSeconds(1);
        $permittedFor = $permittedFor ?? Config::get('app.url');

        $token = $this->config->builder()
            ->issuedBy(Config::get('app.url'))
            ->permittedFor($permittedFor)
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->issuedAt($now->toDateTimeImmutable())
            ->expiresAt($expiresAt->toDateTimeImmutable())
            ->canOnlyBeUsedAfter($canBeUsedAfter->toDateTimeImmutable())
            ->relatedTo($userId);

        $token = $token->getToken($this->config->signer(), $this->config->signingKey());

        $tokenModel = $this->refreshTokenRepository->create(model: RefreshTokenMapper::tokenToModel(token: $token->toString()));

        return $tokenModel->getAttribute('refresh_token');
    }

    /**
     * @throws TokenParsingFailedException
     */
    public function parseTokenToArray(string $token): ?array
    {
        try {
            $parsedToken = $this->config->parser()->parse($token);
        } catch (\Lcobucci\JWT\Exception $e) {
            throw new TokenParsingFailedException();
        }

        $claims = $parsedToken->claims();

        return [
            'iss' => $claims->get('iss'),
            'aud' => $claims->get('aud'),
            'jti' => $claims->get('jti'),
            'iat' => $claims->get('iat'),
            'exp' => $claims->get('exp'),
            'nbf' => $claims->get('nbf'),
            'sub' => $claims->get('sub')
        ];
    }

    public function isTokenValid(string $token): bool
    {
        return $this->isTokenSignatureValid($token);
    }

    public function isTokenSignatureValid(string $token): bool
    {
        $parsedToken = $this->config->parser()->parse($token);
        $pureBase64EncodedHeaders = strtr($parsedToken->headers()->toString(), '-_', '+/');
        $pureBase64EncodedClaims = strtr($parsedToken->claims()->toString(), '-_', '+/');
        $payload = $pureBase64EncodedHeaders . '.' . $pureBase64EncodedClaims;

        $tokenSignature = base64_decode(strtr($parsedToken->signature()->toString(), '-_', '+/'));

        return $this->config->signer()->verify(
            expected: $tokenSignature,
            payload: $payload,
            key: $this->config->verificationKey()
        );
    }
}
