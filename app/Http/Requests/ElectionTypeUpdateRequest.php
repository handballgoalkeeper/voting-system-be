<?php

namespace App\Http\Requests;

use App\Dtos\ElectionTypeDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Mappers\ElectionTypeMapper;

class ElectionTypeUpdateRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:election_types,id',
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'country_id' => 'required|integer|exists:countries,id'
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
