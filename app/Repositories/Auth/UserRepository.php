<?php

namespace App\Repositories\Auth;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Models\User;
use Exception;

class UserRepository
{
    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneByEmail(string $email): User
    {
        try {
            $user = User::firstWhere('email', $email);
        }
        catch (Exception $e) {
            throw new DBOperationException('Something went wrong while getting user with provided email.');
        }

        if (!$user) {
            throw new EntityNotFoundException('User');
        }

        return $user;
    }
}
