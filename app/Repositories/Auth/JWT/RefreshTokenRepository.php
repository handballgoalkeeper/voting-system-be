<?php

namespace App\Repositories\Auth\JWT;

use App\Exceptions\DBOperationException;
use App\Models\RefreshTokenModel;
use Exception;

class RefreshTokenRepository
{
    /**
     * @throws DBOperationException
     */
    public static function create(RefreshTokenModel $model): RefreshTokenModel
    {
        try {
            $model->save();
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while creating refresh token.');
        }

        return $model;
    }
}
