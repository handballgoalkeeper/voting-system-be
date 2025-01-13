<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firsWhere(string $string, int $id)
 * @method static firstWhere(string $string, int $id)
 */
class ElectionModel extends Model
{
    const TABLE = 'elections';
    protected $table = self::TABLE;
    protected $fillable = [
        'country_id',
        'election_type_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];
}
