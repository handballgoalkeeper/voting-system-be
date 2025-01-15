<?php

namespace App\Dtos;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Services\ElectionService;
use Carbon\Carbon;
use JsonSerializable;

class ElectionStageDTO implements JsonSerializable
{
    private ?int $electionId = null;
    private ?ElectionDTO $election = null;

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function __construct(
        private Carbon $startsAt,
        private Carbon $endsAt,
        private ?bool $isFinal = null,
        ?int $electionId = null,
        private ?int $census = null,
        private ?int $coalitionCensus = null,
        private ?int $stageInstantWinThreshold = null,
    )
    {
        $this->setElectionId($electionId);
    }

    public function isFinal(): ?bool
    {
        return $this->isFinal;
    }

    public function setIsFinal(?bool $isFinal): void
    {
        $this->isFinal = $isFinal;
    }

    public function getCensus(): ?int
    {
        return $this->census;
    }

    public function setCensus(?int $census): void
    {
        $this->census = $census;
    }

    public function getCoalitionCensus(): ?int
    {
        return $this->coalitionCensus;
    }

    public function setCoalitionCensus(?int $coalitionCensus): void
    {
        $this->coalitionCensus = $coalitionCensus;
    }

    public function getStageInstantWinThreshold(): ?int
    {
        return $this->stageInstantWinThreshold;
    }

    public function setStageInstantWinThreshold(?int $stageInstantWinThreshold): void
    {
        $this->stageInstantWinThreshold = $stageInstantWinThreshold;
    }

    public function getStartsAt(): Carbon
    {
        return $this->startsAt;
    }

    public function setStartsAt(Carbon $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): Carbon
    {
        return $this->endsAt;
    }

    public function setEndsAt(Carbon $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function setElectionId(?int $electionId): void
    {
        if (!is_null($electionId)) {
            $this->electionId = $electionId;
            $this->election = app(ElectionService::class)->findOneById($electionId);
        }
    }

    public function getElectionId(): ?int
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
