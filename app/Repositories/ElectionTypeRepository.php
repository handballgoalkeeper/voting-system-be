<?php

namespace App\Repositories;

use App\Models\ElectionTypeModel;
use Illuminate\Database\Eloquent\Collection;

class ElectionTypeRepository
{
    public function findAll(): Collection
    {
           return ElectionTypeModel::all();
    }
}
