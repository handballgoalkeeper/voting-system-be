<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $electionId)
 */
class ElectionStageModel extends Model
{
    const TABLE = "election_stages";
    protected $table = self::TABLE;
    protected $fillable = [
        'election_id',
        'census',
        'coalition_census',
        'stage_instant_win_threshold',
        'is_final',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_final' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];
}
