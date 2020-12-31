<?php

declare(strict_types=1);

namespace ComparisonTest\Infrastructure\Controller;

use Comparison\Application\Exception\NotFoundRepositoryException;
use Comparison\Application\Service\CompareManager;
use Comparison\Domain\Exception\InvalidSlugException;
use Comparison\Domain\ValueObject\RepositorySlug;
use Comparison\Infrastructure\Controller\CompareController;
use Comparison\Infrastructure\Utils\GithubParser;
use Comparison\Infrastructure\Utils\ParserInterface;
use Prophecy\Argument;
use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class CompareControllerTest extends AbstractHttpControllerTestCase
{
    use ProphecyTrait;

    protected $compare;

    protected $parser;

    protected function setUp(): void
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $sharedManager = $this->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->clearListeners(AbstractRestfulController::class);

        $this->compare = $this->prophesize(CompareManager::class);
        $this->parser = $this->prophesize(GithubParser::class);

        $services = $this->getApplicationServiceLocator();
        $services->setAllowOverride(true);
        $services->setService(CompareManager::class, $this->compare->reveal());
        $services->setService(GithubParser::class, $this->parser->reveal());
        $services->setAllowOverride(false);
    }

    public function testCompareActionAfterValidGets()
    {
        $params = [
            'compare' => 'https://github.com/zendframework/zendframework',
            'to' => 'symfony/symfony'
        ];
        $this->parser
            ->parse(Argument::type('string'))
            ->shouldBeCalledTimes(2);
        $this->compare
            ->compare(Argument::type(RepositorySlug::class), Argument::type(RepositorySlug::class))
            ->shouldBeCalled();

        $this->dispatch('/api/v1/compare', 'GET', $params);

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Comparison');
        $this->assertControllerName(CompareController::class);
        $this->assertControllerClass('CompareController');
        $this->assertMatchedRouteName('api/v1/compare');
    }

    public function testCompareActionWillThrowAnExceptionAfterInvalidGets()
    {
        $params = [
            'compare' => 'Cubix92/non-existence-repository',
            'to' => 'Cubix92/non-existence-repository'
        ];
        $this->parser
            ->parse(Argument::type('string'))
            ->shouldBeCalledTimes(2);
        $this->compare
            ->compare(Argument::type(RepositorySlug::class), Argument::type(RepositorySlug::class))
            ->willThrow(new NotFoundRepositoryException());

        $this->dispatch('/api/v1/compare', 'GET', $params);

        $this->assertResponseStatusCode(404);
        $this->assertModuleName('Comparison');
        $this->assertControllerName(CompareController::class);
        $this->assertControllerClass('CompareController');
        $this->assertMatchedRouteName('api/v1/compare');
    }

    public function testCompareActionWillThrowAnExceptionAfterFetchingNonExistingRepository()
    {
        $params = [
            'compare' => 'invalid_slug',
            'to' => 'invalid_slug'
        ];
        $this->parser->parse(Argument::type('string'))->willThrow(new InvalidSlugException());

        $this->dispatch('/api/v1/compare', 'GET', $params);

        $this->assertResponseStatusCode(400);
        $this->assertModuleName('Comparison');
        $this->assertControllerName(CompareController::class);
        $this->assertControllerClass('CompareController');
        $this->assertMatchedRouteName('api/v1/compare');
    }
}
