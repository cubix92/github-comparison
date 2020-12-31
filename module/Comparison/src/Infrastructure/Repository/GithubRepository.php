<?php

declare(strict_types=1);

namespace Comparison\Infrastructure\Repository;

use Comparison\Domain\Model\Repository;
use Comparison\Domain\Model\RepositoryHydrator;
use Comparison\Domain\ValueObject\RepositorySlug;
use Github\Client as GithubClient;
use Github\Exception\RuntimeException;

class GithubRepository extends AbstractRepository
{
    protected $client;

    protected $hydrator;

    public function __construct(GithubClient $client)
    {
        $this->client = $client;
    }

    public function findOneBySlug(RepositorySlug $repositorySlug): ?Repository
    {
        $client = $this->client;
        $username = $repositorySlug->getUsername();
        $slug = $repositorySlug->getRepositoryName();

        try {
            $data = $client->api('repo')->show($username, $slug);
        } catch (RuntimeException $e) {
            return null;
        }

        $lastReleaseDate = current($client->api('repo')->releases()->all($username, $slug));

        $data['username'] = $data['owner']['login'];
        $data['stars'] = $data['stargazers_count'];
        $data['watchers'] = $data['subscribers_count'];
        $data['closedPullRequests'] = count($client->api('pull_request')->all($username, $slug, ['state' => 'open']));
        $data['openPullRequests'] = count($client->api('pull_request')->all($username, $slug, ['state' => 'close']));
        $data['lastReleaseDate'] = $lastReleaseDate ? $lastReleaseDate['published_at'] : null;

        return (new RepositoryHydrator)->hydrate($data);
    }
}
