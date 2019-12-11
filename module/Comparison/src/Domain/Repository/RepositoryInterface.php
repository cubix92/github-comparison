<?php

declare(strict_types=1);

namespace Comparison\Domain\Repository;

use Comparison\Domain\Model\Repository;
use Comparison\Domain\ValueObject\RepositorySlug;

interface RepositoryInterface
{
    public function findOneBySlug(RepositorySlug $repositorySlug): ?Repository;
}
