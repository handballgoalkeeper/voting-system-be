<?php

namespace App\Repositories;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\ElectionModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use function PHPUnit\Framework\isNull;

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

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $id): ElectionModel
    {
        try {
            $election = ElectionModel::firstWhere('id', $id);
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while trying to retrieve election with provided id.');
        }

        if (is_null($election)) {
            throw new EntityNotFoundException('Election');
        }

        return $election;
    }
}
