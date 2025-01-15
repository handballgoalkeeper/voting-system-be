<?php

namespace App\Http\Requests;

use App\Dtos\ElectionStageDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Mappers\ElectionStageMapper;

class AddNewElectionStageRequest extends JSONRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'census' => 'integer|nullable|min:0|max:100',
            'coalition_census' => 'integer|nullable|min:0|max:100',
            'stage_instant_win_threshold' => 'integer|nullable|min:0|max:100',
            'starts_at' => 'required|date_format:Y-m-d\TH:i|after:today',
            'ends_at' => 'required|date_format:Y-m-d\TH:i|after:starts_at'
        ];
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function validateToDto(): ElectionStageDto
    {
        return ElectionStageMapper::requestToDto($this->validated());
    }
}
