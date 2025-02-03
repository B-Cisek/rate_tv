<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Symfony\Messenger;

use App\RateTv\Shared\Application\Command\Sync\Command;
use App\RateTv\Shared\Application\Command\Sync\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SyncCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandSyncBus)
    {
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->commandSyncBus->dispatch($command);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}
