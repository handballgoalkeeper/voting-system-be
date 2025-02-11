<?php

namespace App\Dtos;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Services\CountryService;
use JsonSerializable;

class ElectionTypeDTO implements JsonSerializable
{
    private int $countryId;
    private CountryDTO $country;

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function __construct(
        private string $name,
        int $countryId,
        private int $requiredStagesCount,
        private ?int $id = null,
        private ?string $description = null,
    )
    {
        $this->setCountryId($countryId);
    }

    public function getRequiredStagesCount(): int
    {
        return $this->requiredStagesCount;
    }

    public function setRequiredStagesCount(int $requiredStagesCount): void
    {
        $this->requiredStagesCount = $requiredStagesCount;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCountryId(): int
    {
        return $this->getCountry()->getId();
    }

    /**
     * @throws DBOperationException
     * @throws EntityNotFoundException
     */
    public function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
        $this->country = app(CountryService::class)->findOneById($this->countryId);
    }

    public function getCountry(): CountryDTO
    {
        return $this->country;
    }

    public function setCountry(CountryDTO $country): void
    {
        $this->countryId = $country->getId();
        $this->country = $country;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'required_stages_count' => $this->getRequiredStagesCount(),
            'country' => $this->getCountry(),
        ];
    }
}
