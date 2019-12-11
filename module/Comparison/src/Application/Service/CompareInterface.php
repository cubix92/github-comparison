<?php

declare(strict_types=1);

namespace Comparison\Application\Service;

use Comparison\Domain\ValueObject\RepositorySlug;

interface CompareInterface
{
    public function compare(RepositorySlug $firstRepositorySlug, RepositorySlug $secondRepositorySlug): array;
}
