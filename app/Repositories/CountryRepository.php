<?php

namespace App\Repositories;

use App\Exceptions\DBOperationException;
use App\Models\CountryModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;

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
}
