<?php

declare(strict_types=1);

namespace ComparisonTest\Application\Hydrator;

use Comparison\Application\Exception\InvalidArgumentException as ParserInvalidArgument;
use Comparison\Domain\Exception\InvalidSlugException;
use Comparison\Application\Service\GithubParser;
use Comparison\Application\Service\ParserInterface;
use Comparison\Domain\ValueObject\RepositorySlug;
use PHPUnit\Framework\TestCase;

class GithubParserTest extends TestCase
{
    /** @var ParserInterface $githubParser */
    private $githubParser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->githubParser = new GithubParser;
    }

    public function testParsesRepositoryNameCorrectly()
    {
        $repositoryParameter = 'example/example';

        $repositorySlug = $this->githubParser->parse($repositoryParameter);

        $this->assertInstanceOf(RepositorySlug::class, $repositorySlug);
        $this->assertEquals($repositoryParameter, (string) $repositorySlug);
    }

    public function testParsesUrlCorrectly()
    {
        $repositoryParameter = 'example/example';
        $urlParameter = 'https://github.com/example/example';

        $repositorySlug = $this->githubParser->parse($repositoryParameter);

        $this->assertInstanceOf(RepositorySlug::class, $repositorySlug);
        $this->assertNotEquals($urlParameter, (string) $repositorySlug);
        $this->assertEquals($repositoryParameter, (string) $repositorySlug);
    }

    public function testExceptionIsThrownWhenPassingInvalidUrlParameter()
    {
        $invalidUrlParameter = 'ftp://github.com/example/example';

        $this->expectException(ParserInvalidArgument::class);
        $this->expectExceptionMessage(
            "'$invalidUrlParameter' is invalid. Please correct this parameter and will send it again."
        );

        $this->githubParser->parse($invalidUrlParameter);
    }

    public function testExceptionIsThrownWhenPassingEmptyParameter()
    {
        $emptyParameter = '';

        $this->expectException(InvalidSlugException::class);
        $this->expectExceptionMessage("Passing parameter is empty.");

        $this->githubParser->parse($emptyParameter);
    }
}
