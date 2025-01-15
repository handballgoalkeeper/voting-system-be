<?php

namespace App\Http\Requests;

use App\Dtos\ElectionTypeDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Mappers\ElectionTypeMapper;

class ElectionTypeCreateRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'required_stages_count' => 'required|integer|min:1',
        ];
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function validateToDto(): ElectionTypeDTO
    {
        $data = $this->validated();
        return ElectionTypeMapper::requestToDto(data: $data, requestName: self::class);
    }
}
