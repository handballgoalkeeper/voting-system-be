<?php

namespace App\Repositories;

use App\Dtos\CountryDTO;
use App\Dtos\ElectionTypeDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\ElectionTypeModel;
use Exception;
use http\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
            throw new DBOperationException('Something went wrong while trying to retrieve election type with provided id.');
        }

        if (is_null($electionType)) {
            throw new EntityNotFoundException('Election type');
        }

        return $electionType;
    }

    /**
     * @throws DBOperationException
     */
    public function create(ElectionTypeModel $electionType): ElectionTypeModel
    {
        try {
            $electionType->save();
        }
        catch (Exception $e) {
            throw new DBOperationException(message: 'Something went wrong while trying to create new election type.');
        }

        return $electionType;
    }

    /**
     * @throws DBOperationException
     */
    public function isValueUniqueForCountry(string $column, mixed $value, CountryDTO $country, ElectionTypeModel $excludedModel = null): bool
    {
        try {
            if (is_null($excludedModel)) {
                $count = DB::table(ElectionTypeModel::TABLE)
                    ->select([
                        'id'
                    ])
                    ->where(column: $column, operator: '=', value: $value)
                    ->where(column: 'country_id', operator: '=', value: $country->getId())
                    ->count();

                return $count === 0;
            }

            $count = DB::table(ElectionTypeModel::TABLE)
                ->select([
                    'id'
                ])
                ->where(column: $column, operator: '=', value: $value)
                ->where(column: 'country_id', operator: '=', value: $country->getId())
                ->whereNot(column: 'id', operator: '=', value: $excludedModel->getAttribute('id'))
                ->count();

            return $count === 0;
        }
        catch (Exception $e) {
            throw new DBOperationException(message: "Something went wrong while checking uniqueness of values provided.");
        }
    }
}
