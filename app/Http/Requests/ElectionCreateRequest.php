<?php

namespace App\Http\Requests;

use App\Dtos\ElectionDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Mappers\ElectionMapper;
use Illuminate\Foundation\Http\FormRequest;

class ElectionCreateRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'election_type_id' => 'required|exists:election_types,id'
        ];
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function validateToDto(): ElectionDTO
    {
        $data = $this->validated();
        return ElectionMapper::requestToDto(data: $data, requestName: self::class);
    }
}
