<?php

declare(strict_types=1);

namespace ComparisonTest\Domain\Model;

use Comparison\Domain\Model\Repository;

class RepositoryFactory
{
    const USERNAME = 'example-username';
    const NAME = 'example-repository';
    const FORKS = 120;
    const STARS = 1112;
    const WATCHERS = 500;
    const OPEN_PULL_REQUESTS = 12;
    const CLOSE_PULL_REQUESTS = 42;
    const LAST_RELEASE_DATE = '2019-12-01 12:03:12';
    const SCORE = 1762;

    const DEFAULT_DATA = [
        'username' => self::USERNAME,
        'name' => self::NAME,
        'forks' => self::FORKS,
        'stars' => self::STARS,
        'watchers' => self::WATCHERS,
        'openPullRequests' => self::OPEN_PULL_REQUESTS,
        'closePullRequests' => self::CLOSE_PULL_REQUESTS,
        'lastReleaseDate' => self::LAST_RELEASE_DATE
    ];

    public static function create(array $data = []): Repository
    {
        $result = array_merge(self::DEFAULT_DATA, $data);

        return new Repository(
            $result['name'],
            $result['username'],
            $result['forks'],
            $result['stars'],
            $result['watchers'],
            $result['openPullRequests'],
            $result['closePullRequests'],
            new \DateTime($result['lastReleaseDate'])
        );
    }
}
