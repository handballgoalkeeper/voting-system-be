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


    /**
     * @throws DBOperationException
     */
    public function findStagesCountByElectionId(int $electionId): int
    {
        try {
            $stageCount = ElectionStageModel::where('election_id', $electionId)->count();
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while fetching election stages count.');
        }

        return $stageCount;
    }

    /**
     * @throws DBOperationException
     */
    public function create(ElectionStageModel $model): ElectionStageModel
    {
//        try {
            $model->save();
//        }
//        catch (Exception $e) {
//            throw new DBOperationException('Something went wrong while saving election stage.');
//        }

        return $model;
    }
}
