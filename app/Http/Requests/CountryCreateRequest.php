<?php

namespace App\Http\Requests;

use App\Dtos\CountryDto;
use App\Mappers\CountryMapper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class CountryCreateRequest extends Request
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

    public function validateToDto(): CountryDto
    {
        $data = $this->validated();
        return new CountryDto(
            name: $data['name'],
            totalVoters: $data['total_voters'],
        );
    }
}
