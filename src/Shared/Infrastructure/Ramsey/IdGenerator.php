<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Ramsey;

use App\RateTv\Shared\Application\Service\IdGeneratorInterface;
use App\RateTv\Shared\Domain\Id;
use Ramsey\Uuid\Uuid;

final class IdGenerator implements IdGeneratorInterface
{
    public function generate(): Id
    {
        return new Id(Uuid::uuid7()->toString());
    }
}
