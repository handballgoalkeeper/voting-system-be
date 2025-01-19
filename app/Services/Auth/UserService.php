<?php

namespace App\Services\Auth;

use App\Dtos\Auth\UserDTO;
use App\Exceptions\Auth\AuthenticationFailedException;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Mappers\Auth\UserMapper;
use App\Repositories\Auth\UserRepository;
use Illuminate\Support\Facades\Hash;

readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneByEmail(string $email): UserDTO
    {
        return UserMapper::modelToDto($this->userRepository->findOneByEmail(email: $email));
    }

    /**
     * @throws AuthenticationFailedException
     */
    public function validatePassword(UserDTO $user, string $passwordToValidate): void
    {
        if (!Hash::check($passwordToValidate, $user->getPassword())) {
            throw new AuthenticationFailedException();
        }
    }
}
