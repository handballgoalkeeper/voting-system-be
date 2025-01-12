<?php

namespace App\Mappers;

use App\Dtos\ElectionTypeDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ElectionTypeCreateRequest;
use App\Http\Requests\JSONRequest;
use App\Models\ElectionTypeModel;
use Illuminate\Database\Eloquent\Collection;

class ElectionTypeMapper
{
    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function modelToDto(ElectionTypeModel $model): ElectionTypeDto
    {
        return new ElectionTypeDTO(
            name: $model->getAttribute('name'),
            countryId: $model->getAttribute('country_id'),
            id: $model->getAttribute('id'),
//            Pitati da li ostaviti kao sad, da DTO vadi, ili ovde direktono iz model pozvati country
            description: $model->getAttribute('description'),
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
            $output[] = self::modelToDTO($model);
        }
        return $output;
    }

    public static function dtoToModel(ElectionTypeDTO $dto): ElectionTypeModel
    {
        return new ElectionTypeModel([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'country_id' => $dto->getCountryId(),
        ]);
    }


    /**
     * @param array<ElectionTypeDTO> $dtos
     * @return array<ElectionTypeModel>
     */
    public static function dtosToModels(array $dtos): array
    {
        $output = [];

        foreach ($dtos as $dto) {
            $output[] = self::dtoToModel($dto);
        }

        return $output;
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function requestToDto(array $data, string $requestName): ?ElectionTypeDTO
    {
        if ($requestName === ElectionTypeCreateRequest::class) {
            $dto = new ElectionTypeDTO(
                name: $data['name'],
                countryId: $data['country_id']
            );

            if (isset($data['description'])) {
                $dto->setDescription($data['description']);
            }

            return $dto;
        }
        return null;
    }
}
