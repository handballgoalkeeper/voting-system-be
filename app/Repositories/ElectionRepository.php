<?php

namespace App\Repositories;

use App\Models\ElectionModel;
use Illuminate\Database\Eloquent\Collection;

class ElectionRepository
{
    public function findAll(): Collection
    {
        return ElectionModel::all();
    }
}
