<?php

namespace App\Repositories;

use App\Exceptions\DBOperationException;
use App\Models\ElectionStageModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ElectionStageRepository
{
    /**
     * @throws DBOperationException
     */
    public function findAllByElectionId(int $electionId): Collection
    {
        try {
            $stages = ElectionStageModel::where('election_id', $electionId)->get();
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while fetching election stages for provided election.');
        }

        return $stages;
    }
}
