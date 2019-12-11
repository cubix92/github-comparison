<?php

declare(strict_types=1);

namespace Comparison\Application\Hydrator;

use Comparison\Domain\Model\Repository;

interface RepositoryHydratorInterface
{
    public function extract(Repository $repository): array;

    public function hydrate(array $data): Repository;
}
