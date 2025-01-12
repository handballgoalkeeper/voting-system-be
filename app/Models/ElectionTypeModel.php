<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static firstWhere(string $string, int $id)
 */
class ElectionTypeModel extends Model
{
    const TABLE = 'election_types';
    protected $table = self::TABLE;
    protected $fillable = [
        'name',
        'description',
        'country_id'
    ];

    public function country(): HasOne
    {
        return $this->hasOne(related: CountryModel::class, foreignKey: 'id', localKey: 'country_id');
    }
}
