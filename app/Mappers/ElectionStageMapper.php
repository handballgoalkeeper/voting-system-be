<?php

namespace App\Mappers;

use App\Dtos\ElectionStageDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\ElectionStageModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ElectionStageMapper
{
    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function modelToDto(ElectionStageModel $model): ElectionStageDTO
    {
        return new ElectionStageDTO(
            startsAt: $model->getAttribute("starts_at"),
            endsAt: $model->getAttribute("ends_at"),
            isFinal: $model->getAttribute("is_final"),
            electionId: $model->getAttribute("election_id"),
            census: $model->getAttribute("census"),
            coalitionCensus: $model->getAttribute("coalition_census"),
            stageInstantWinThreshold: $model->getAttribute("stage_instant_win_threshold")
        );
    }


    /**
     * @return array<ElectionStageDTO>
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function modelsToDtos(Collection $models): array
    {
        $output = [];

        foreach ($models as $model) {
            $output[] = self::modelToDto($model);
        }
        return $output;
    }

    public static function dtoToModel(ElectionStageDTO $electionStageDTO): ElectionStageModel
    {
        $model = new ElectionStageModel([
            'election_id' => $electionStageDTO->getElection()->getId(),
            'census' => $electionStageDTO->getCensus(),
            'coalition_census' => $electionStageDTO->getCensus(),
            'stage_instant_win_threshold' => $electionStageDTO->getStageInstantWinThreshold(),
            'starts_at' => $electionStageDTO->getStartsAt(),
            'ends_at' => $electionStageDTO->getEndsAt()
        ]);

        if (!is_null($electionStageDTO->isFinal())) {
            $model->setAttribute('is_final', $electionStageDTO->isFinal());
        }

        return $model;

    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function requestToDto(array $requestData): ElectionStageDTO
    {
        $dto = new ElectionStageDTO(
            startsAt: Carbon::parse($requestData["starts_at"]),
            endsAt: Carbon::parse($requestData["ends_at"])
        );

        if (isset($requestData["census"])) {
            $dto->setCensus($requestData["census"]);
        }

        if (isset($requestData["coalition_census"])) {
            $dto->setCoalitionCensus($requestData["coalition_census"]);
        }

        if (isset($requestData["stage_instant_win_threshold"])) {
            $dto->setStageInstantWinThreshold($requestData["stage_instant_win_threshold"]);
        }

        if (isset($requestData["is_final"])) {
            $dto->setIsFinal($requestData["is_final"]);
        }

        if (isset($requestData["election_id"])) {
            $dto->setElectionId($requestData["election_id"]);
        }

        return $dto;
    }
}
