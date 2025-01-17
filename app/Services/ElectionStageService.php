<?php

namespace App\Services;

use App\Dtos\ElectionStageDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FailedConstraintException;
use App\Mappers\ElectionStageMapper;
use App\Repositories\ElectionStageRepository;
use App\Validators\ElectionStageTimetableValidator;

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
     * @return array<ElectionStageDTO>
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
        $electionRequiredStageCount = $this->electionTypeService
            ->findOneById(
                electionTypeId: $electionId
            )
            ->getRequiredStagesCount();

        $electionCurrentStageCount = $this->electionStageRepository
            ->findStagesCountByElectionId(
                electionId: $electionId
            );

        if ($electionRequiredStageCount === $electionCurrentStageCount)
        {
            throw new FailedConstraintException('Election stage maximum count reached for election you specified.');
        }

        $newElectionStageDTO->setElectionId($electionId);

        ElectionStageTimetableValidator::validateElectionStage(electionDTO: $newElectionStageDTO);

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

    /**
     * @throws DBOperationException
     */
    public function findStageCountByElectionId(int $electionId): int
    {
        return $this->electionStageRepository->findStagesCountByElectionId($electionId);
    }
}
