<?php

namespace App\Repositories;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\ElectionTypeModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ElectionTypeRepository
{
    public function findAll(): Collection
    {
           return ElectionTypeModel::all();
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $id): ElectionTypeModel
    {
        try {
            $electionType = ElectionTypeModel::firstWhere('id', $id);
        }
        catch (Exception $e) {
            throw new DBOperationException('');
        }

        if (is_null($electionType)) {
            throw new EntityNotFoundException('Election type');
        }

        return $electionType;
    }
}
