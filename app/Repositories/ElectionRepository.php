<?php

namespace App\Repositories;

use App\Exceptions\DBOperationException;
use App\Models\ElectionModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ElectionRepository
{
    public function findAll(): Collection
    {
        return ElectionModel::all();
    }

    /**
     * @throws DBOperationException
     */
    public function create(ElectionModel $model): ElectionModel
    {
        try {
            $model->save();
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while trying to create new election.');
        }

        return $model;
    }
}
