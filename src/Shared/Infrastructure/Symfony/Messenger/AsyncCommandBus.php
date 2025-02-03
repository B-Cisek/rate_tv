<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Symfony\Messenger;

use App\RateTv\Shared\Application\Command\Async\Command;
use App\RateTv\Shared\Application\Command\Async\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class AsyncCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandAsyncBus)
    {
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->commandAsyncBus->dispatch($command);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}
