<?php

namespace App\Services;

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
     */
    public function findAll()
    {
        $electionTypes = $this->electionTypeRepository->findAll();

        if ($electionTypes->isEmpty()) {
            throw new EntityNotFoundException('Election type');
        }

        return ElectionTypeMapper::models_to_dtos($electionTypes);
    }
}
