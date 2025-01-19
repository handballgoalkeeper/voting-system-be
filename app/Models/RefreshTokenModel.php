<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshTokenModel extends Model
{
    const TABLE = 'refresh_tokens';
    
    protected $table = self::TABLE;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'refresh_token',
        'issued_at',
        'expires_at',
        'is_revoked'
    ];
    protected $casts = [
        'is_revoked' => 'boolean'
    ];
}
