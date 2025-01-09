<?php

namespace App\Dtos;

use JsonSerializable;

class CountryDto implements JsonSerializable
{
    public function __construct(
        private string $name,
        private int $totalVoters,
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

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'totalVoters' => $this->totalVoters,
        ];
    }
}
