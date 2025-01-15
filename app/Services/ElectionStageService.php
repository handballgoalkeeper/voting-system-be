<?php

namespace App\Services;

use App\Dtos\ElectionStageDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FailedConstraintException;
use App\Mappers\ElectionStageMapper;
use App\Repositories\ElectionStageRepository;

readonly class ElectionStageService
{
    public function __construct(
        private ElectionStageRepository $electionStageRepository,
        private ElectionTypeService $electionTypeService
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

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     * @throws FailedConstraintException
     */
    public function addStageToElection(int $electionId, ElectionStageDTO $newElectionStageDTO): ElectionStageDTO
    {
        $newElectionStageDTO->setElectionId($electionId);

        if ($this->electionTypeService
            ->findOneById(
                electionTypeId: $newElectionStageDTO
                    ->getElection()
                    ->getElectionType()
                    ->getId()
            )
            ->getRequiredStagesCount() === $this->electionStageRepository->findStagesCountByElectionId(
                electionId: $electionId
            )
        ) {
            throw new FailedConstraintException('Election stage maximum count reached for election you specified.');
        }


        if ($this->stageSlotsLeftByElectionId($electionId) === 1) {
            $newElectionStageDTO->setIsFinal(true);
        }

        $stage = $this->electionStageRepository->create(ElectionStageMapper::dtoToModel($newElectionStageDTO));

        return ElectionStageMapper::modelToDto($stage);
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function stageSlotsLeftByElectionId(int $electionId): int
    {
        $election = app(ElectionService::class)->findOneById(electionId: $electionId);
        $currentStagesCount = $this->electionStageRepository->findStagesCountByElectionId($electionId);

        return  $election->getElectionType()->getRequiredStagesCount() - $currentStagesCount;
    }
}
