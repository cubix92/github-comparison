<?php

declare(strict_types=1);

namespace ComparisonTest\Infrastructure\Repository;

use Comparison\Domain\Model\Repository;
use Comparison\Domain\Repository\RepositoryInterface;
use Comparison\Domain\ValueObject\RepositorySlug;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class GithubRepositoryTest extends AbstractHttpControllerTestCase
{
    /** @var RepositoryInterface $repositoryService */
    private $repositoryService;

    protected function setUp(): void
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../../config/application.config.php',
            $configOverrides
        ));

        $this->repositoryService = $this->getApplicationServiceLocator()->get(RepositoryInterface::class);

        parent::setUp();
    }

    public function testFindOneBySlugReturnsRepository()
    {
        $validRepositorySlug = 'laminas/laminas-barcode';
        $repositorySlug = new RepositorySlug($validRepositorySlug);

        $repository = $this->repositoryService->findOneBySlug($repositorySlug);

        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertEquals($repositorySlug->getUsername(), $repository->getUsername());
        $this->assertEquals($repositorySlug->getRepositoryName(), $repository->getName());
    }

    public function testFindOneBySlugReturnsNull()
    {
        $nonExistsRepositorySlug = 'Cubix92/non-exists-repo';
        $repositorySlug = new RepositorySlug($nonExistsRepositorySlug);

        $repository = $this->repositoryService->findOneBySlug($repositorySlug);

        $this->assertNull($repository);
    }
}
