<?php

namespace App\Mappers;

use App\Dtos\ElectionDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\ElectionModel;
use Illuminate\Database\Eloquent\Collection;

class ElectionMapper
{

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function modelToDto(ElectionModel $model): ElectionDTO
    {
        return new ElectionDTO(
            countryId: $model->getAttribute("country_id"),
            electionTypeId: $model->getAttribute("election_type_id"),
            isPublished: $model->getAttribute("is_published"),
            published_at: $model->getAttribute("published_at"),
            id: $model->getAttribute("id"),
        );
    }

    /**
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
