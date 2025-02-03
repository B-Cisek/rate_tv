<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Symfony\Messenger;

use App\RateTv\Shared\Application\Event\EventBus;
use App\RateTv\Shared\Domain\DomainEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class AsyncEventBus implements EventBus
{
    public function __construct( private MessageBusInterface $eventBus)
    {
    }

    public function dispatch(DomainEvent $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}
