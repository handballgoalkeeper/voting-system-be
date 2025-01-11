<?php

namespace App\Http\Requests;

use App\Dtos\CountryDTO;
use Illuminate\Foundation\Http\FormRequest;

class CountryCreateRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:countries,name',
            'total_voters' => 'required|integer|min:1',
        ];
    }

    public function validateToDto(): CountryDTO
    {
        $data = $this->validated();
        return new CountryDTO(
            name: $data['name'],
            totalVoters: $data['total_voters'],
        );
    }
}
