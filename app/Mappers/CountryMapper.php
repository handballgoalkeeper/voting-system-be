<?php

namespace App\Mappers;

use App\Dtos\CountryDTO;
use App\Http\Requests\CountryCreateRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\CountryModel;
use Illuminate\Database\Eloquent\Collection;

class CountryMapper
{
    public static function modelToDto(CountryModel $country): CountryDTO
    {
        return new CountryDTO(
            name: $country->getAttribute("name"),
            totalVoters: $country->getAttribute("total_voters"),
            id: $country->getAttribute("id"),
        );
    }


    /**
     * @return array<CountryDTO>
     */
    public static function modelsToDtos(Collection $countries): array
    {
        $output = [];

        foreach ($countries as $country) {
            $output[] = self::modelToDto($country);
        }

        return $output;
    }

    public static function dtoToModel(CountryDTO $countryDTO): CountryModel
    {
        return new CountryModel([
            'name' => $countryDTO->getName(),
            'total_voters' => $countryDTO->getTotalVoters()
        ]);
    }

    public static function requestToDto(array $data, string $requestName): ?CountryDTO
    {
        return match ($requestName) {
            CountryCreateRequest::class => new CountryDTO(
                name: $data["name"],
                totalVoters: $data["total_voters"]
            ),
            UpdateCountryRequest::class => new CountryDTO(
                name: $data["name"],
                totalVoters: $data["total_voters"],
                id: $data["id"]
            ),
            default => null,
        };
    }
}
