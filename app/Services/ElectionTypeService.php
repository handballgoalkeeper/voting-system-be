<?php

namespace App\Services;

use App\Dtos\ElectionTypeDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\ValueNotUniqueException;
use App\Mappers\ElectionTypeMapper;
use App\Repositories\ElectionTypeRepository;

class ElectionTypeService
{
    public function __construct(
        private readonly ElectionTypeRepository $electionTypeRepository
    )
    {
    }

    /**
     * @return array<ElectionTypeDTO>
     * @throws EntityNotFoundException | DBOperationException
     */
    public function findAll(): array
    {
        $electionTypes = $this->electionTypeRepository->findAll();

        if ($electionTypes->isEmpty()) {
            throw new EntityNotFoundException('Election type');
        }

        return ElectionTypeMapper::modelsToDtos($electionTypes);
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $electionTypeId): ElectionTypeDTO
    {
        return ElectionTypeMapper::modelToDto($this->electionTypeRepository->findOneById($electionTypeId));
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     * @throws ValueNotUniqueException
     */
    public function create(ElectionTypeDTO $data): ElectionTypeDTO
    {
        if (!$this->electionTypeRepository->isValueUniqueForCountry(column: 'name', value: $data->getName(), country: $data->getCountry())) {
            throw new ValueNotUniqueException();
        }

        $newElectionType = $this->electionTypeRepository->create(ElectionTypeMapper::dtoToModel($data));
        return ElectionTypeMapper::modelToDto($newElectionType);
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     * @throws ValueNotUniqueException
     */
    public function update(ElectionTypeDTO $updatedData): ElectionTypeDTO
    {
        $currentState = $this->electionTypeRepository->findOneById($updatedData->getId());

        if (!$this->electionTypeRepository->isValueUniqueForCountry(column: 'name', value: $updatedData->getName(), country: $updatedData->getCountry(), excludedModel: $currentState)) {
            throw new ValueNotUniqueException();
        }

        $currentState->setAttribute('name', $updatedData->getName());
        $currentState->setAttribute('description', $updatedData->getDescription());
        $currentState->setAttribute('country_id', $updatedData->getCountry()->getId());

        if ($currentState->isDirty())
        {
            $currentState = $this->electionTypeRepository->save(model: $currentState);
        }

        return ElectionTypeMapper::modelToDto($currentState);



    }
}
