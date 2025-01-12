<?php

namespace App\Mappers;

use App\Dtos\ElectionDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ElectionCreateRequest;
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

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public static function requestToDto(array $data, string $requestName): ?ElectionDTO
    {
        if ($requestName === ElectionCreateRequest::class) {
            return new ElectionDTO(
                countryId: $data["country_id"],
                electionTypeId: $data["election_type_id"],
                isPublished: false
            );
        }
        return null;
    }

    public static function dtoToModel(ElectionDTO $dto): ElectionModel
    {
        return new ElectionModel([
            "country_id" => $dto->getCountry()->getId(),
            "election_type_id" => $dto->getElectionType()->getId(),
            "is_published" => $dto->isPublished()
        ]);
    }

}
