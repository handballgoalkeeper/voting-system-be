<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    const TABLE_NAME = "countries";

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        "name",
        "total_voters"
    ];
}
