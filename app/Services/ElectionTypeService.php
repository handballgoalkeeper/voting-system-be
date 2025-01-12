<?php

namespace App\Services;

use App\Dtos\ElectionTypeDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
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
     * @throws EntityNotFoundException
     * @return array<ElectionTypeDTO>
     */
    public function findAll(): array
    {
        $electionTypes = $this->electionTypeRepository->findAll();

        if ($electionTypes->isEmpty()) {
            throw new EntityNotFoundException('Election type');
        }

        return ElectionTypeMapper::models_to_dtos($electionTypes);
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $electionTypeId): ElectionTypeDTO
    {
        return ElectionTypeMapper::model_to_dto($this->electionTypeRepository->findOneById($electionTypeId));
    }
}
