<?php

namespace App\Validators;

use App\Dtos\ElectionStageDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FailedConstraintException;
use App\Services\ElectionStageService;

class ElectionStageTimetableValidator
{

    /**
     * @param ElectionStageDTO $electionDTO
     * @param array<ElectionStageDTO> $currentStages
     * @return bool
     * @throws FailedConstraintException
     */
    private static function validateStartsAt(ElectionStageDTO $electionDTO, array $currentStages): bool
    {
        $failed = false;
        $currentStagesLatestEndDate = null;

        foreach ($currentStages as $currentStage) {
            if ($currentStage->getEndsAt()->greaterThan($electionDTO->getStartsAt())) {
                $failed = true;
                if (!is_null($currentStagesLatestEndDate) &&
                    $currentStagesLatestEndDate->greaterThan($currentStage->getEndsAt())) {
                    continue;
                }
                $currentStagesLatestEndDate = $currentStage->getEndsAt();
            }

            if ($failed) {
                throw new FailedConstraintException(message: "Starts at must be later than {$currentStagesLatestEndDate}.");
            }
        }

        return true;
    }

    /**
     * @param ElectionStageDTO $electionDTO
     * @param array<ElectionStageDTO> $currentStages
     * @return bool
     * @throws FailedConstraintException
     */
    private static function validateEndsAt(ElectionStageDTO $electionDTO, array $currentStages): bool
    {
        $failed = false;
        $currentStagesLatestEndDate = null;

        foreach ($currentStages as $currentStage) {
            if ($currentStage->getEndsAt()->greaterThan($electionDTO->getEndsAt())) {
                $failed = true;
                if (!is_null($currentStagesLatestEndDate) &&
                    $currentStagesLatestEndDate->greaterThan($currentStage->getEndsAt())) {
                    continue;
                }
                $currentStagesLatestEndDate = $currentStage->getEndsAt();
            }

            if ($failed) {
                throw new FailedConstraintException(message: "Ends at must be later than {$currentStagesLatestEndDate}.");
            }
        }

        return true;
    }

    /**
     * @throws FailedConstraintException
     */
    public static function validateElectionStage(ElectionStageDTO $electionDTO): bool
    {
        try {
            $currentStages = app(ElectionStageService::class)->findAllByElectionId(
                electionId: $electionDTO->getElection()->getId()
            );
        }
        catch (EntityNotFoundException) {
            return true;
        } catch (DBOperationException|FailedConstraintException $e) {
            return false;
        }

        return self::validateStartsAt(
            electionDTO: $electionDTO,
            currentStages: $currentStages
        ) &&
        self::validateEndsAt(
            electionDTO: $electionDTO,
            currentStages: $currentStages
        );
    }
}
