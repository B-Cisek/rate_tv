<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Domain;

final class DomainEventDispatcher implements DomainEventDispatcherInterface
{
    /**
     * @var DomainEventListenerInterface[]
     */
    private array $listeners;

    /**
     * @param DomainEventListenerInterface[] $listeners
     */
    public function __construct(iterable $listeners)
    {
        foreach ($listeners as $listener) {
            $this->listeners[] = $listener;
        }
    }

    public function dispatch(DomainEvent ...$domainEvents): void
    {
        foreach ($domainEvents as $event) {
            foreach ($this->listeners as $listener) {
                $listener->handle($event);
            }
        }
    }
}
