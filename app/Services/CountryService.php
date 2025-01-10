<?php

namespace App\Services;

use App\Dtos\CountryDto;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Mappers\CountryMapper;
use App\Repositories\CountryRepository;

readonly class CountryService
{
    public function __construct(
        private CountryRepository $countryRepository
    )
    {
    }

    /**
     * @throws EntityNotFoundException
     * @return array<CountryDto>
     */
    public function findAll(): array
    {
        $countries = $this->countryRepository->findAll();

        if ($countries->isEmpty()) {
            throw new EntityNotFoundException(entityName: 'Country');
        }

        return CountryMapper::modelsToDtos($countries);
    }

    /**
     * @throws DBOperationException
     */
    public function create(CountryDto $data): CountryDto
    {
        $newCountry = $this->countryRepository->create(CountryMapper::dtoToModel($data));
        return CountryMapper::modelToDto($newCountry);
    }
}
