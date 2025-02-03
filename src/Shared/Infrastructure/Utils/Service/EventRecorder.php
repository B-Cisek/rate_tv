<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Utils\Service;

use App\RateTv\Shared\Application\Service\IdGeneratorInterface;
use App\RateTv\Shared\Domain\DomainEvent;
use App\RateTv\Shared\Domain\DomainEventListenerInterface;
use App\RateTv\Shared\Infrastructure\Doctrine\Repository\EventRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\RateTv\Shared\Infrastructure\Doctrine\Entity\Event as EventEntity;

final readonly class EventRecorder implements DomainEventListenerInterface
{
    public function __construct(
        private EventRepository $repository,
        private NormalizerInterface $normalizer,
        private IdGeneratorInterface $idGenerator
    ) {
    }

    public function handle(DomainEvent $event): void
    {
        /** @var mixed[] $payload */
        $payload = $this->normalizer->normalize($event);

        /** @var DateTimeImmutable $occurredAt */
        $occurredAt = DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $event->occurredAt);

        $this->repository->save(
            new EventEntity(
                $this->idGenerator->generate()->toString(),
                $event::class,
                $occurredAt,
                $payload
            )
        );
    }
}
