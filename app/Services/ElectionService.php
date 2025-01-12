<?php

namespace App\Services;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Facade\ResponseFacade;
use App\Mappers\ElectionMapper;
use App\Repositories\ElectionRepository;
use Exception;
use Illuminate\Http\JsonResponse;

readonly class ElectionService
{
    public function __construct(
        private readonly ElectionRepository $electionRepository
    )
    {
    }

    /**
     * @throws EntityNotFoundException
     * @throws DBOperationException
     */
    public function findAll(): array
    {
        $elections = $this->electionRepository->findAll();

        if ($elections->isEmpty()) {
            throw new EntityNotFoundException('Election');
        }

        return ElectionMapper::modelsToDtos($elections);
    }
}
