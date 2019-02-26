<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/20/19
 * Time: 7:12 PM
 */

namespace RockBuzz\Blog\Domain\Post;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Blog\Domain\RepositoryException;
use RockBuzz\Blog\Domain\RequestFactory;

class PostRepository {

    /** @var Logger */
    private $logger;

    /** @var Client */
    private $client;

    /** @var RequestFactory */
    private $requestFactory;

    public function __construct(Container $container) {
        $this->logger         = $container[Logger::class];
        $this->client         = $container[Client::class];
        $this->requestFactory = $container[RequestFactory::class];
    }

    /**
     * @param array $args
     * @return PostResource[]
     */
    public function findAll(array $args = []): array {
        $query = "";
        if (!empty($args)) {
            $query = "?".http_build_query($args);
        }

        $request = $this->requestFactory->getInstance("GET", "/api/posts".$query);

        try {
            $response = $this->client->send($request);
            return PostResource::collection(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to retrieve posts from posts service.", 0, $ex);
        }
    }

    public function findOneBySlug(string $slug): PostResource {
        $request = $this->requestFactory->getInstance("GET", "/api/posts/slug/{$slug}");

        try {
            $response = $this->client->send($request);
            return PostResource::single(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to retrieve post {$slug} from posts service.", 0, $ex);
        }
    }
}