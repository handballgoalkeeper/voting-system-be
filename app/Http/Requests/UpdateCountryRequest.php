<?php

namespace App\Http\Requests;

use App\Dtos\CountryDTO;
use App\Mappers\CountryMapper;

class UpdateCountryRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "id" => "required|integer|exists:countries,id",
            "name" => "required|string|max:255",
            "total_voters" => "required|integer|min:1",
        ];
    }

    public function validateToDto(): CountryDTO
    {
        $data = $this->validated();
        return CountryMapper::requestToDto(data: $data, requestName: self::class);
    }
}
