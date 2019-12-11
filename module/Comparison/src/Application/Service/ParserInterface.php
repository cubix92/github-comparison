<?php

declare(strict_types=1);

namespace Comparison\Application\Service;

use Comparison\Domain\ValueObject\RepositorySlug;

interface ParserInterface
{
    public function parse(string $parameter): RepositorySlug;
}
