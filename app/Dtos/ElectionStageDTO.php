<?php

namespace App\Dtos;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Services\ElectionService;
use Carbon\Carbon;
use JsonSerializable;

class ElectionStageDTO implements JsonSerializable
{
    private int $electionId;
    private ElectionDTO $election;

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function __construct(
        int $electionId,
        private bool $isFinal,
        private ?float $census = null,
        private ?float $coalitionCensus = null,
        private ?float $stageInstantWinThreshold = null,
        private ?Carbon $startsAt = null,
        private ?Carbon $endsAt = null
    )
    {
        $this->setElectionId($electionId);
    }

    public function isFinal(): bool
    {
        return $this->isFinal;
    }

    public function setIsFinal(bool $isFinal): void
    {
        $this->isFinal = $isFinal;
    }

    public function getCensus(): ?float
    {
        return $this->census;
    }

    public function setCensus(?float $census): void
    {
        $this->census = $census;
    }

    public function getCoalitionCensus(): ?float
    {
        return $this->coalitionCensus;
    }

    public function setCoalitionCensus(?float $coalitionCensus): void
    {
        $this->coalitionCensus = $coalitionCensus;
    }

    public function getStageInstantWinThreshold(): ?float
    {
        return $this->stageInstantWinThreshold;
    }

    public function setStageInstantWinThreshold(?float $stageInstantWinThreshold): void
    {
        $this->stageInstantWinThreshold = $stageInstantWinThreshold;
    }

    public function getStartsAt(): ?Carbon
    {
        return $this->startsAt;
    }

    public function setStartsAt(?Carbon $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): ?Carbon
    {
        return $this->endsAt;
    }

    public function setEndsAt(?Carbon $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function setElectionId(int $electionId): void
    {
        $this->electionId = $electionId;
        $this->election = app(ElectionService::class)->findOneById($electionId);
    }

    public function getElectionId(): int
    {
        return $this->electionId;
    }

    public function getElection(): ElectionDTO
    {
        return $this->election;
    }

    public function setElection(ElectionDTO $election): void
    {
        $this->election = $election;
        $this->electionId = $election->getId();
    }

    public function jsonSerialize(): array
    {
        return [
            'startsAt' => $this->getStartsAt(),
            'endsAt' => $this->getEndsAt(),
            'isFinal' => $this->isFinal(),
            'coalitionCensus' => $this->getCoalitionCensus(),
            'stageInstantWinThreshold' => $this->getStageInstantWinThreshold(),
            'census' => $this->getCensus()
        ];
    }
}
