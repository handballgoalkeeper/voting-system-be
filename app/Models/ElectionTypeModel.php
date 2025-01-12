<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionTypeModel extends Model
{
    const TABLE = 'election_types';
    protected $table = self::TABLE;
    protected $fillable = [
        'name',
        'description',
        'country_id'
    ];
}
