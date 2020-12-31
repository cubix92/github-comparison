<?php

declare(strict_types=1);

namespace Comparison\Domain\ValueObject;

use Comparison\Domain\Exception\InvalidSlugException;

class RepositorySlug
{
    private string $username;

    private string $repositoryName;

    public function __construct(string $slug)
    {
        $slugParts = explode('/', $slug);

        if (count($slugParts) != 2) {
            throw new InvalidSlugException("'$slug' is not a valid slug");
        }

        list($username, $repositoryName) = explode('/', $slug);

        $this->username = $username;
        $this->repositoryName = $repositoryName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    public function __toString(): string
    {
        return $this->username . '/' . $this->repositoryName;
    }
}
