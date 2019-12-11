<?php

declare(strict_types=1);

namespace Comparison\Infrastructure\Repository;

use Comparison\Domain\Model\Repository;
use Comparison\Domain\Repository\RepositoryInterface;
use Comparison\Domain\ValueObject\RepositorySlug;

abstract class AbstractRepository implements RepositoryInterface
{
    abstract public function findOneBySlug(RepositorySlug $repositorySlug): ?Repository;
}
