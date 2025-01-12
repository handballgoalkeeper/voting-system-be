<?php

namespace App\Dtos;

use JsonSerializable;

class CountryDTO implements JsonSerializable
{
    public function __construct(
        private string $name,
        private int $totalVoters,
        private ?int $id = null
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTotalVoters(): int
    {
        return $this->totalVoters;
    }

    public function setTotalVoters(int $totalVoters): void
    {
        $this->totalVoters = $totalVoters;
    }

    public function getId(): int
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
            'id' => $this->id,
            'name' => $this->name,
            'totalVoters' => $this->totalVoters,
        ];
    }
}
