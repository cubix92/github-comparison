<?php

declare(strict_types=1);

namespace Comparison\Domain\ValueObject;

use Comparison\Domain\Exception\InvalidSlugException;
use PHPUnit\Framework\TestCase;

class RepositorySlugTest extends TestCase
{
    public function testGetsPropertiesCorrectly(): void
    {
        $validSlug = 'laminas/laminas-barcode';
        list($username, $repositoryName) = explode('/', $validSlug);

        $repositorySlug = new RepositorySlug($validSlug);

        $this->assertIsString($repositorySlug->getUsername());
        $this->assertIsString($repositorySlug->getRepositoryName());
        $this->assertEquals($username, $repositorySlug->getUsername());
        $this->assertEquals($repositoryName, $repositorySlug->getRepositoryName());
        $this->assertEquals($validSlug, (string) $repositorySlug);
    }

    public function testExceptionIsThrownWhenPassingInvalidSlug()
    {
        $invalidSlug = 'zendframework zend-barcode';

        $this->expectException(InvalidSlugException::class);
        $this->expectExceptionMessage("'$invalidSlug' is not a valid slug");

        new RepositorySlug($invalidSlug);
    }
}
