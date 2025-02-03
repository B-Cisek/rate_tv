<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Domain;

interface DomainEventDispatcherInterface
{
    public function dispatch(DomainEvent ...$domainEvents): void;
}
