<?php

declare(strict_types=1);

namespace ComparisonTest\Domain\Model;

use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    public function testGetsPropertiesCorrectly(): void
    {
        $repository = RepositoryFactory::create();
        $lastReleaseDate = $repository->getLastReleaseDate();

        $this->assertIsString($repository->getUsername());
        $this->assertIsString($repository->getName());
        $this->assertIsInt($repository->countForks());
        $this->assertIsInt($repository->countStars());
        $this->assertIsInt($repository->countWatchers());
        $this->assertIsInt($repository->countOpenPullRequests());
        $this->assertIsInt($repository->countClosedPullRequests());
        $this->assertInstanceOf(\DateTime::class, $lastReleaseDate);

        $this->assertEquals($repository->getUsername(), RepositoryFactory::USERNAME);
        $this->assertEquals($repository->getName(), RepositoryFactory::NAME);
        $this->assertEquals($repository->countForks(), RepositoryFactory::FORKS);
        $this->assertEquals($repository->countStars(), RepositoryFactory::STARS);
        $this->assertEquals($repository->countWatchers(), RepositoryFactory::WATCHERS);
        $this->assertEquals($repository->countOpenPullRequests(), RepositoryFactory::OPEN_PULL_REQUESTS);
        $this->assertEquals($repository->countClosedPullRequests(), RepositoryFactory::CLOSE_PULL_REQUESTS);
        $this->assertEquals($lastReleaseDate->format('Y-m-d H:i:s'), RepositoryFactory::LAST_RELEASE_DATE);
    }

    public function testCalculatesScoresCorrectly(): void
    {
        $firstRepository = RepositoryFactory::create();
        $secondRepository = RepositoryFactory::create([
            'closedPullRequests' => RepositoryFactory::CLOSE_PULL_REQUESTS + 10
        ]);
        $thirdRepository = RepositoryFactory::create([
            'openPullRequests' => RepositoryFactory::OPEN_PULL_REQUESTS + 20
        ]);

        $this->assertIsInt($firstRepository->calculateScore());
        $this->assertEquals(RepositoryFactory::SCORE, $firstRepository->calculateScore());
        $this->assertEquals(RepositoryFactory::SCORE + 10, $secondRepository->calculateScore());
        $this->assertEquals(RepositoryFactory::SCORE - 20, $thirdRepository->calculateScore());
    }
}
