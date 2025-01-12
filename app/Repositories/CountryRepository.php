<?php

namespace App\Repositories;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\CountryModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CountryRepository
{
    public function findAll(): Collection
    {
        return CountryModel::all();
    }

    /**
     * @throws DBOperationException
     */
    public function create(CountryModel $country): CountryModel
    {
        try {
            $country->save();
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while trying to create new country.');
        }

        return $country;
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $id): CountryModel
    {
        try {
            $country = CountryModel::firstWhere('id', $id);
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while trying to retrieve country with provided id.');
        }

        if (is_null($country)) {
            throw new EntityNotFoundException();
        }

        return $country;
    }

    /**
     * @throws DBOperationException
     */
    public function save(CountryModel $model): CountryModel
    {
        try {
            $model->save();
        }
        catch (Exception) {
            throw new DBOperationException('Something went wrong while trying to save model.');
        }

        return $model;
    }

    /**
     * @throws DBOperationException
     */
    public function isValueUnique(mixed $value, string $columnName, CountryModel $excludedModel): bool
    {
        try {
            $count = DB::table(CountryModel::TABLE)
                ->select([
                    'id'
                ])
                ->where(column: $columnName, operator: '=', value: $value)
                ->whereNot(column: 'id', operator: '=', value: $excludedModel->getAttribute('id'))
                ->count();
        }
        catch (Exception) {
            throw new DBOperationException("Something went wrong while checking uniqueness of values provided.");
        }

        return $count === 0;
    }
}
