<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Domain;

interface DomainEventListenerInterface
{
    public function handle(DomainEvent $event): void;
}
