<?php

declare(strict_types=1);

namespace Comparison\Application\Service;

use Comparison\Application\Exception\NotFoundRepositoryException;
use Comparison\Domain\Model\RepositoryHydrator;
use Comparison\Domain\Repository\RepositoryInterface;
use Comparison\Domain\ValueObject\RepositorySlug;

class CompareManager
{
    private RepositoryInterface $repositoryService;

    public function __construct(RepositoryInterface $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    public function compare(RepositorySlug $firstRepositorySlug, RepositorySlug $secondRepositorySlug): array
    {
        $firstRepository = $this->repositoryService->findOneBySlug($firstRepositorySlug);
        if (!$firstRepository) {
            throw new NotFoundRepositoryException("Repository with slug {$firstRepositorySlug} was not found.");
        }

        $secondRepository = $this->repositoryService->findOneBySlug($secondRepositorySlug);
        if (!$secondRepository) {
            throw new NotFoundRepositoryException("Repository with slug {$secondRepositorySlug} was not found.");
        }

        $data = [];
        $data[] = (new RepositoryHydrator())->extract($firstRepository);
        $data[] = (new RepositoryHydrator())->extract($secondRepository);

        return $data;
    }
}
