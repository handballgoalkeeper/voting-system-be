<?php

namespace App\Services;

use App\Dtos\CountryDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\ValueNotUniqueException;
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
     * @return array<CountryDTO>
     *@throws EntityNotFoundException
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
    public function create(CountryDTO $data): CountryDTO
    {
        $newCountry = $this->countryRepository->create(CountryMapper::dtoToModel($data));
        return CountryMapper::modelToDto($newCountry);
    }

    /**
     * @throws DBOperationException
     * @throws ValueNotUniqueException
     * @throws EntityNotFoundException
     */
    public function update(CountryDTO $updatedData): CountryDTO
    {
        $currentState = $this->countryRepository->findOneById($updatedData->getId());

        if (!$this->countryRepository->isValueUnique(value: $updatedData->getName(), columnName: 'name', excludedModel: $currentState)) {
            throw new ValueNotUniqueException();
        }

        $currentState->setAttribute('name', $updatedData->getName());
        $currentState->setAttribute('total_voters', $updatedData->getTotalVoters());

        if ($currentState->isDirty())
        {
            $currentState = $this->countryRepository->save(model: $currentState);
        }

        return CountryMapper::modelToDto($currentState);
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $id): CountryDTO
    {
        return CountryMapper::modelToDto($this->countryRepository->findOneById($id));
    }
}
