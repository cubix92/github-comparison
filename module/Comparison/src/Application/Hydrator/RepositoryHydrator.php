<?php

declare(strict_types=1);

namespace Comparison\Application\Hydrator;

use Comparison\Domain\Model\Repository;

class RepositoryHydrator implements RepositoryHydratorInterface
{
    public function extract(Repository $repository): array
    {
        $lastReleaseDate = $repository->getLastReleaseDate();

        return [
            'name' => $repository->getName(),
            'username' => $repository->getUsername(),
            'forks' => $repository->countForks(),
            'stars' => $repository->countStars(),
            'watchers' => $repository->countWatchers(),
            'openPullRequests' => $repository->countOpenPullRequests(),
            'closedPullRequests' => $repository->countClosedPullRequests(),
            'lastReleaseDate' => $lastReleaseDate ? $lastReleaseDate->format('Y-m-d H:i:s') : null,
            'score' => $repository->calculateScore()
        ];
    }

    public function hydrate(array $data): Repository
    {
        return new Repository(
            $data['name'],
            $data['username'],
            $data['forks'],
            $data['stars'],
            $data['watchers'],
            $data['openPullRequests'],
            $data['closedPullRequests'],
            $data['lastReleaseDate'] ? new \DateTime($data['lastReleaseDate']) : null
        );
    }
}
