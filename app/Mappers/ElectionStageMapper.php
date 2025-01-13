<?php

namespace App\Mappers;

use App\Dtos\ElectionStageDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\ElectionStageModel;
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
            electionId: $model->getAttribute("election_id"),
            isFinal: $model->getAttribute("is_final"),
            census: $model->getAttribute("census"),
            coalitionCensus: $model->getAttribute("coalition_census"),
            stageInstantWinThreshold: $model->getAttribute("stage_instant_win_threshold"),
            startsAt: $model->getAttribute("starts_at"),
            endsAt: $model->getAttribute("ends_at")
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
}
