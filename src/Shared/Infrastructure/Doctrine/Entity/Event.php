<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Doctrine\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Event
{
    #[Id]
    #[Column(type: Types::GUID)]
    private string $id;

    #[Column(type: Types::STRING, length: 128)]
    private string $type;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $occurredAt;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $sent = null;

    /**
     * @var mixed[]
     */
    #[Column(type: Types::JSON)]
    private array $payload;

    /**
     * @param mixed[] $payload
     */
    public function __construct(
        string $id,
        string $type,
        DateTimeImmutable $occurredAt,
        array $payload
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->occurredAt = $occurredAt;
        $this->payload = $payload;
    }

    public function sent(): void
    {
        $this->sent = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function getSentDate(): ?DateTimeImmutable
    {
        return $this->sent;
    }

    /**
     * @return mixed[]
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
