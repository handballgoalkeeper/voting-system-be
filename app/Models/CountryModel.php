<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstWhere(string $string, int $id)
 * @method static findOrFail(int $id)
 */
class CountryModel extends Model
{
    const TABLE_NAME = "countries";

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        "name",
        "total_voters"
    ];
}
