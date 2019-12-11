<?php

declare(strict_types=1);

namespace Comparison\Application\Service;

use Comparison\Domain\ValueObject\RepositorySlug;
use Zend\Uri\Exception\InvalidArgumentException;
use Comparison\Application\Exception\InvalidArgumentException as ParserInvalidArgument;
use Zend\Uri\Uri;
use Zend\Uri\UriFactory;

class GithubParser implements ParserInterface
{
    public function parse(string $parameter): RepositorySlug
    {
        if (!$parameter) {
            throw new ParserInvalidArgument(
                "Passing parameter is empty."
            );
        }

        $filteredParameter = strip_tags(trim($parameter));

        try {
            /** @var Uri $uri */
            $uri = UriFactory::factory($filteredParameter);
        } catch (InvalidArgumentException $e) {
            throw new ParserInvalidArgument(
                "'$parameter' is invalid. Please correct this parameter and will send it again."
            );
        }

        $slug = trim($uri->getPath(), '/');

        if(!$slug) {
            throw new ParserInvalidArgument(
                "'$parameter' is invalid. Please correct this parameter and will send it again."
            );
        }

        return new RepositorySlug($slug);
    }
}
