<?php

namespace App\Mappers;

use App\Dtos\ElectionTypeDTO;
use App\Models\ElectionTypeModel;
use Illuminate\Database\Eloquent\Collection;

class ElectionTypeMapper
{
    public static function model_to_dto(ElectionTypeModel $model): ElectionTypeDto
    {
        return new ElectionTypeDTO(
            id: $model->getAttribute('id'),
            name: $model->getAttribute('name'),
            description: $model->getAttribute('description'),
//            Pitati da li ostaviti kao sad, da DTO vadi, ili ovde direktono iz model pozvati country
            countryId: $model->getAttribute('country_id'),
        );
    }


    /**
     * @param Collection $models
     * @return array<ElectionTypeDTO>
     */
    public static function models_to_dtos(Collection $models): array
    {
        $output = [];

        foreach ($models as $model) {
            $output[] = self::model_to_dto($model);
        }
        return $output;
    }
}
