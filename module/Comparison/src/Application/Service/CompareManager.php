<?php

declare(strict_types=1);

namespace Comparison\Application\Service;

use Comparison\Application\Exception\NotFoundRepositoryException;
use Comparison\Application\Hydrator\RepositoryHydrator;
use Comparison\Domain\Repository\RepositoryInterface;
use Comparison\Domain\ValueObject\RepositorySlug;

class CompareManager implements CompareInterface
{
    private $repositoryService;

    private $repositoryHydrator;

    public function __construct(RepositoryInterface $repositoryService, RepositoryHydrator $repositoryHydrator)
    {
        $this->repositoryService = $repositoryService;
        $this->repositoryHydrator = $repositoryHydrator;
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
        $data[] = $this->repositoryHydrator->extract($firstRepository);
        $data[] = $this->repositoryHydrator->extract($secondRepository);

        return $data;
    }
}
