<?php

declare(strict_types=1);

namespace Comparison\Domain\Model;

/**
 * @SWG\Definition(
 *     definition="Repository",
 *     @SWG\Property(property="name", type="string", example="test-repo"),
 *     @SWG\Property(property="username", type="string", example="Test"),
 *     @SWG\Property(property="forks", type="integer", example=110),
 *     @SWG\Property(property="stars", type="integer", example=1200),
 *     @SWG\Property(property="watchers", type="integer", example=567),
 *     @SWG\Property(property="openPullRequests", type="integer", example=49),
 *     @SWG\Property(property="closedPullRequests", type="integer", example=120),
 *     @SWG\Property(property="lastReleaseDate", type="string", example="2018-12-31 12:30:01"),
 *     @SWG\Property(property="score", type="integer", example=1234)
 * )
 */
class Repository
{
    private $name;

    private $username;

    private $forks;

    private $stars;

    private $watchers;

    private $openPullRequests;

    private $closedPullRequests;

    private $lastReleaseDate;

    public function __construct(
        string $name,
        string $username,
        int $forks,
        int $stars,
        int $watchers,
        int $openPullRequests,
        int $closedPullRequests,
        ?\DateTime $releaseDate
    ) {
        $this->name = $name;
        $this->username = $username;
        $this->forks = $forks;
        $this->stars = $stars;
        $this->watchers = $watchers;
        $this->openPullRequests = $openPullRequests;
        $this->closedPullRequests = $closedPullRequests;
        $this->lastReleaseDate = $releaseDate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function countForks(): int
    {
        return $this->forks;
    }

    public function countStars(): int
    {
        return $this->stars;
    }

    public function countWatchers(): int
    {
        return $this->watchers;
    }

    public function countOpenPullRequests(): int
    {
        return $this->openPullRequests;
    }

    public function countClosedPullRequests(): int
    {
        return $this->closedPullRequests;
    }

    public function getLastReleaseDate(): ?\DateTime
    {
        return $this->lastReleaseDate;
    }

    public function calculateScore(): int
    {
        return $this->stars + $this->forks + $this->watchers + $this->closedPullRequests - $this->openPullRequests;
    }
}
