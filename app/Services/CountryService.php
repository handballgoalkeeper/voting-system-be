<?php

namespace App\Services;

use App\Dtos\CountryDto;
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

        return CountryMapper::models_to_dtos($countries);
    }
}
