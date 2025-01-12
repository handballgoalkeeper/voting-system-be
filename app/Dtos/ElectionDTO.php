<?php

namespace App\Dtos;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Services\CountryService;
use App\Services\ElectionTypeService;
use Carbon\Carbon;
use JsonSerializable;

class ElectionDTO implements JsonSerializable
{
    private CountryDTO $country;
    private int $countryId;
    private ElectionTypeDTO $electionType;
    private int $electionTypeId;

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function __construct(
        int $countryId,
        int $electionTypeId,
        private bool $isPublished,
        private ?Carbon $published_at = null,
        private ?int $id = null
    )
    {
        $this->setCountryId($countryId);
        $this->setElectionTypeId($electionTypeId);

    }

    public function getCountry(): CountryDTO
    {
        return $this->country;
    }
    public function getCountryId(): int
    {
        return $this->country->getId();
    }

    public function getElectionType(): ElectionTypeDTO
    {
        return $this->electionType;
    }

    public function setElectionType(ElectionTypeDTO $electionType): void
    {
        $this->electionTypeId = $electionType->getId();
        $this->electionType = $electionType;
    }
    public function setCountry(CountryDTO $country): void
    {
        $this->countryId = $country->getId();
        $this->country = $country;
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function setCountryId(int $country_id): void
    {
        $this->countryId = $country_id;
        $this->country = app(CountryService::class)->findOneById($this->countryId);
    }

    public function getElectionTypeId(): int
    {
        return $this->electionType->getId();
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function setElectionTypeId(int $electionTypeId): void
    {
        $this->electionTypeId = $electionTypeId;
        $this->electionType = app(ElectionTypeService::class)->findOneById($this->electionTypeId);
    }

    public function getPublishedAt(): ?Carbon
    {
        return $this->published_at;
    }

    public function setPublishedAt(?Carbon $published_at): void
    {
        $this->published_at = $published_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): void
    {
        $this->isPublished = $isPublished;
    }



    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'country' => [
                'id' => $this->getCountry()->getId(),
                'name' => $this->getCountry()->getName()
            ],
            'electionType' => [
                'id' => $this->getElectionType()->getId(),
                'name' => $this->getElectionType()->getName(),
                'description' => $this->getElectionType()->getDescription()
            ],
            'is_published' => $this->isPublished(),
            'published_at' => $this->getPublishedAt(),
        ];
    }
}
