<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Domain;

abstract readonly class DomainEvent
{
    public int $version;
    public string $aggregateId;
    public string $name;
    public string $occurredAt;

    public function __construct(
        string $aggregateId,
        string $name,
        int $version,
        string $occurredAt
    ) {
        $this->aggregateId = $aggregateId;
        $this->name = $name;
        $this->version = $version;
        $this->occurredAt = $occurredAt;
    }
}
