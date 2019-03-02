<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/20/19
 * Time: 7:12 PM
 */

namespace RockBuzz\Admin\Domain\Post;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pimple\Container;
use RockBuzz\Admin\Domain\RepositoryException;
use RockBuzz\Admin\Domain\RequestFactory;

class PostRepository {

    /** @var Client */
    private $client;

    /** @var RequestFactory */
    private $requestFactory;

    public function __construct(Container $container) {
        $this->client         = $container[Client::class];
        $this->requestFactory = $container[RequestFactory::class];
    }

    /**
     * @return PostResource[]
     */
    public function findAll(): array {
        $request = $this->requestFactory->getInstance("GET", "/api/posts");

        try {
            $response = $this->client->send($request);
            return PostResource::collection(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to retrieve posts from posts service.", 0, $ex);
        }
    }

    public function findOne($id): PostResource {
        $request = $this->requestFactory->getInstance("GET", "/api/posts/{$id}");

        try {
            $response = $this->client->send($request);
            return PostResource::single(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to retrieve post {$id} from posts service.", 0, $ex);
        }
    }

    public function save(array $post): PostResource {
        $request = null;
        if (isset($post["id"])) {
            $request = $this->requestFactory->getInstance("PUT", "/api/posts/{$post["id"]}");
        } else {
            $request = $this->requestFactory->getInstance("POST", "/api/posts");
        }

        try {
            $response = $this->client->send($request, [
                "json" => $post,
            ]);
            return PostResource::single(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to send post to posts service.", 0, $ex);
        }
    }
}