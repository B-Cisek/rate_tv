<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Symfony\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(KernelEvents::EXCEPTION)]
final class ExceptionListener
{
    public function __construct(private string $environment)
    {
    }

    public function __invoke(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationError)
        {

        }

    }
}
