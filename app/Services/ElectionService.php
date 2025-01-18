<?php

namespace App\Services;

use App\Dtos\ElectionDTO;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FailedConstraintException;
use App\Facade\ResponseFacade;
use App\Mappers\ElectionMapper;
use App\Models\ElectionModel;
use App\Repositories\ElectionRepository;
use Exception;
use Illuminate\Http\JsonResponse;

readonly class ElectionService
{
    public function __construct(
        private ElectionRepository $electionRepository
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

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     * @throws FailedConstraintException
     */
    public function create(ElectionDTO $requestData): ElectionDTO
    {
        if ($requestData->getElectionType()->getCountry()->getId() !== $requestData->getCountry()->getId()) {
            throw new FailedConstraintException('Provided election type is not of provided country.');
        }

        return ElectionMapper::modelToDto($this->electionRepository->create(ElectionMapper::dtoToModel($requestData)));
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function findOneById(int $electionId): ElectionDTO
    {
        return ElectionMapper::modelToDto($this->electionRepository->findOneById($electionId));
    }

    /**
     * @throws DBOperationException
     */
    public function existsWithId(int $electionId): bool
    {
        try {
            $this->electionRepository->findOneById($electionId);
        } catch (EntityNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     * @throws FailedConstraintException
     */
    public function publishByElectionId(int $electionId): ElectionDTO
    {
        $election = $this->electionRepository->findOneById($electionId);

        if ($election->getAttribute('is_published')) {
            throw new FailedConstraintException('Election is already published.');
        }

        $election->setAttribute('is_published', true);

        if ($election->isDirty())
        {
            $election = $this->electionRepository->save($election);
        }

        return ElectionMapper::modelToDto($election);
    }

}
