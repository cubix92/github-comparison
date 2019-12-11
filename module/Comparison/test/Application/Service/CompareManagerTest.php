<?php

declare(strict_types=1);

namespace ComparisonTest\Application\Hydrator;

use Comparison\Application\Hydrator\RepositoryHydrator;
use Comparison\Application\Service\CompareManager;
use Comparison\Domain\Model\Repository;
use Comparison\Domain\Repository\RepositoryInterface;
use Comparison\Domain\ValueObject\RepositorySlug;
use ComparisonTest\Domain\Model\RepositoryFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class CompareManagerTest extends TestCase
{
    /** @var RepositoryInterface $repository */
    private $repository;

    /** @var RepositoryHydrator $hydrator */
    private $hydrator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->prophesize(RepositoryInterface::class);
        $this->hydrator = $this->prophesize(RepositoryHydrator::class);
    }

    public function testComparesRepositoriesCorrectly()
    {
        $repository = RepositoryFactory::create();
        $firstRepositorySlug = new RepositorySlug('zendframework/zendframework');
        $secondRepositorySlug = new RepositorySlug('symfony/symfony');
        $this->repository->findOneBySlug(Argument::type(RepositorySlug::class))
            ->willReturn($repository)
            ->shouldBeCalled();
        $this->hydrator->extract(Argument::type(Repository::class))
            ->willReturn(RepositoryFactory::DEFAULT_DATA)
            ->shouldBeCalled();
        $compareManager = new CompareManager(
            $this->repository->reveal(),
            $this->hydrator->reveal()
        );

        $result = $compareManager->compare($firstRepositorySlug, $secondRepositorySlug);
        $firstResult = current($result);
        $secondResult = end($result);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertIsArray($firstResult);
        $this->assertArrayHasKey('username', $firstResult);
        $this->assertArrayHasKey('name', $firstResult);
        $this->assertArrayHasKey('forks', $firstResult);
        $this->assertArrayHasKey('stars', $firstResult);
        $this->assertArrayHasKey('watchers', $firstResult);
        $this->assertArrayHasKey('openPullRequests', $firstResult);
        $this->assertArrayHasKey('closePullRequests', $firstResult);
        $this->assertArrayHasKey('lastReleaseDate', $firstResult);
        $this->assertIsArray($secondResult);
        $this->assertArrayHasKey('username', $secondResult);
        $this->assertArrayHasKey('name', $secondResult);
        $this->assertArrayHasKey('forks', $secondResult);
        $this->assertArrayHasKey('stars', $secondResult);
        $this->assertArrayHasKey('watchers', $secondResult);
        $this->assertArrayHasKey('openPullRequests', $secondResult);
        $this->assertArrayHasKey('closePullRequests', $secondResult);
        $this->assertArrayHasKey('lastReleaseDate', $secondResult);
    }
}
