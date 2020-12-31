<?php

declare(strict_types=1);

namespace ComparisonTest\Application\Hydrator;

use Comparison\Domain\Model\RepositoryHydrator;
use ComparisonTest\Domain\Model\RepositoryFactory;
use PHPUnit\Framework\TestCase;

class RepositoryHydratorTest extends TestCase
{
    /** @var RepositoryHydrator $repositoryHydrator */
    private $repositoryHydrator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryHydrator = new RepositoryHydrator;
    }

    public function testHydratesPropertiesCorrectly()
    {
        $data = [
            'name' => RepositoryFactory::NAME,
            'username' => RepositoryFactory::USERNAME,
            'forks' => RepositoryFactory::FORKS,
            'stars' => RepositoryFactory::STARS,
            'watchers' => RepositoryFactory::WATCHERS,
            'openPullRequests' => RepositoryFactory::OPEN_PULL_REQUESTS,
            'closedPullRequests' => RepositoryFactory::CLOSE_PULL_REQUESTS,
            'lastReleaseDate' => RepositoryFactory::LAST_RELEASE_DATE
        ];

        $repository = $this->repositoryHydrator->hydrate($data);

        $this->assertIsNotArray($repository);
        $this->assertEquals($repository->getUsername(), RepositoryFactory::USERNAME);
        $this->assertEquals($repository->getName(), RepositoryFactory::NAME);
        $this->assertEquals($repository->countForks(), RepositoryFactory::FORKS);
        $this->assertEquals($repository->countStars(), RepositoryFactory::STARS);
        $this->assertEquals($repository->countWatchers(), RepositoryFactory::WATCHERS);
        $this->assertEquals($repository->countOpenPullRequests(), RepositoryFactory::OPEN_PULL_REQUESTS);
        $this->assertEquals($repository->countClosedPullRequests(), RepositoryFactory::CLOSE_PULL_REQUESTS);
        $this->assertEquals($repository->getLastReleaseDate()
            ->format('Y-m-d H:i:s'), RepositoryFactory::LAST_RELEASE_DATE);
    }

    public function testExtractsPropertiesCorrectly()
    {
        $repository = RepositoryFactory::create();

        $data = $this->repositoryHydrator->extract($repository);

        $this->assertIsArray($data);
        $this->assertEquals($data['username'], RepositoryFactory::USERNAME);
        $this->assertEquals($data['name'], RepositoryFactory::NAME);
        $this->assertEquals($data['forks'], RepositoryFactory::FORKS);
        $this->assertEquals($data['stars'], RepositoryFactory::STARS);
        $this->assertEquals($data['watchers'], RepositoryFactory::WATCHERS);
        $this->assertEquals($data['openPullRequests'], RepositoryFactory::OPEN_PULL_REQUESTS);
        $this->assertEquals($data['closedPullRequests'], RepositoryFactory::CLOSE_PULL_REQUESTS);
        $this->assertEquals($data['lastReleaseDate'], RepositoryFactory::LAST_RELEASE_DATE);
    }
}
