<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstWhere(string $string, int $id)
 * @method static findOrFail(int $id)
 */
class CountryModel extends Model
{
    const TABLE = "countries";

    protected $table = self::TABLE;

    protected $fillable = [
        "name",
        "total_voters"
    ];
}
