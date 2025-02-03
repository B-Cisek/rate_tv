<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Application\Event;

use App\RateTv\Shared\Domain\DomainEvent;

interface EventBus
{
    public function dispatch(DomainEvent $event): void;
}
