<?php

namespace App\Mappers;

use App\Dtos\CountryDto;
use App\Models\CountryModel;
use Illuminate\Database\Eloquent\Collection;

class CountryMapper
{
    public static function model_to_dto(CountryModel $country): CountryDTO
    {
        return new CountryDTO(
            name: $country->getAttribute("name"),
            totalVoters: $country->getAttribute("total_voters"),
        );
    }


    /**
     * @return array<CountryDto>
     */
    public static function models_to_dtos(Collection $countries): array
    {
        $output = [];

        foreach ($countries as $country) {
            $output[] = self::model_to_dto($country);
        }

        return $output;
    }
}
