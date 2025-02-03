<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Application\Service;

use App\RateTv\Shared\Domain\Id;

interface IdGeneratorInterface
{
    public function generate(): Id;
}
