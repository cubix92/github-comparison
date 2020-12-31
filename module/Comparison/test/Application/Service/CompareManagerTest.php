<?php

declare(strict_types=1);

namespace ComparisonTest\Application\Service;

use Comparison\Application\Service\CompareManager;
use Comparison\Domain\Repository\RepositoryInterface;
use Comparison\Domain\ValueObject\RepositorySlug;
use ComparisonTest\Domain\Model\RepositoryFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class CompareManagerTest extends TestCase
{
    use ProphecyTrait;

    /** @var RepositoryInterface $repository */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->prophesize(RepositoryInterface::class);
    }

    public function testComparesRepositoriesCorrectly()
    {
        $repository = RepositoryFactory::create();
        $firstRepositorySlug = new RepositorySlug('zendframework/zendframework');
        $secondRepositorySlug = new RepositorySlug('symfony/symfony');
        $this->repository->findOneBySlug(Argument::type(RepositorySlug::class))
            ->willReturn($repository)
            ->shouldBeCalled();
        $compareManager = new CompareManager(
            $this->repository->reveal()
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
        $this->assertArrayHasKey('closedPullRequests', $firstResult);
        $this->assertArrayHasKey('lastReleaseDate', $firstResult);
        $this->assertIsArray($secondResult);
        $this->assertArrayHasKey('username', $secondResult);
        $this->assertArrayHasKey('name', $secondResult);
        $this->assertArrayHasKey('forks', $secondResult);
        $this->assertArrayHasKey('stars', $secondResult);
        $this->assertArrayHasKey('watchers', $secondResult);
        $this->assertArrayHasKey('openPullRequests', $secondResult);
        $this->assertArrayHasKey('closedPullRequests', $secondResult);
        $this->assertArrayHasKey('lastReleaseDate', $secondResult);
        $this->assertEquals(RepositoryFactory::USERNAME, $firstResult['username']);
        $this->assertEquals(RepositoryFactory::NAME, $firstResult['name']);
        $this->assertEquals(RepositoryFactory::FORKS, $firstResult['forks']);
        $this->assertEquals(RepositoryFactory::STARS, $firstResult['stars']);
        $this->assertEquals(RepositoryFactory::WATCHERS, $firstResult['watchers']);
        $this->assertEquals(RepositoryFactory::OPEN_PULL_REQUESTS, $firstResult['openPullRequests']);
        $this->assertEquals(RepositoryFactory::CLOSE_PULL_REQUESTS, $firstResult['closedPullRequests']);
        $this->assertEquals(RepositoryFactory::LAST_RELEASE_DATE, $firstResult['lastReleaseDate']);
    }
}
