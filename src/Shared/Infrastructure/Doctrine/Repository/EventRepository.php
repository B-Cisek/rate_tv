<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\RateTv\Shared\Infrastructure\Doctrine\Entity\Event as EventEntity;

final readonly class EventRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(EventEntity $event): void
    {
        $this->entityManager->persist($event);
    }

    /**
     * @return EventEntity[]
     */
    public function findUnsent(int $limit): array
    {
        /** @var EventEntity[] $events */
        $events = $this->entityManager
            ->createQueryBuilder()
            ->select('e')
            ->from(EventEntity::class, 'e')
            ->andWhere('e.sent IS NULL')
            ->setMaxResults($limit)
            ->addOrderBy('e.occurredAt', 'ASC')
            ->addOrderBy('e.id')
            ->getQuery()
            ->getResult();

        return $events;
    }
}
