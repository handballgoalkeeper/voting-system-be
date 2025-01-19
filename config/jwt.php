<?php
    return [
        'secret' => env('JWT_SECRET'),
        'token_ttl' => (int) env('jwt_token_ttl', 15),
        'refresh_ttl' => (int) env('jwt_refresh_ttl', 10080),
    ];
