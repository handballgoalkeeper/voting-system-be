<?php

namespace App\Repositories;

use App\Models\CountryModel;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository
{
    public function findAll(): Collection
    {
        return CountryModel::all();
    }
}
