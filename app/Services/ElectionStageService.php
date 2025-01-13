<?php

namespace App\Services;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FailedConstraintException;
use App\Mappers\ElectionStageMapper;
use App\Repositories\ElectionStageRepository;

readonly class ElectionStageService
{
    public function __construct(
        private ElectionStageRepository $electionStageRepository
    )
    {
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     * @throws FailedConstraintException
     */
    public function findAllByElectionId(int $electionId): array
    {
        if (!app(ElectionService::class)->existsWithId($electionId)) {
            throw new FailedConstraintException('Election with provided id does not exist.');
        }

        $stages = $this->electionStageRepository->findAllByElectionId($electionId);

        if ($stages->isEmpty()) {
            throw new EntityNotFoundException("Election stages");
        }

        return ElectionStageMapper::modelsToDtos($stages);
    }
}
