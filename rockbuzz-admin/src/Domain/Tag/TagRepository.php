<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 2:52 PM
 */

namespace RockBuzz\Admin\Domain\Tag;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pimple\Container;
use RockBuzz\Admin\Domain\RepositoryException;
use RockBuzz\Admin\Domain\RequestFactory;

class TagRepository {

    /** @var Client */
    private $client;

    /** @var RequestFactory */
    private $requestFactory;

    public function __construct(Container $container) {
        $this->client         = $container[Client::class];
        $this->requestFactory = $container[RequestFactory::class];
    }

    /**
     * @return TagResource[]
     */
    public function findAll(): array {
        $request = $this->requestFactory->getInstance("GET", "/api/tags");

        try {
            $response = $this->client->send($request);
            return TagResource::collection(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to retrieve tags from posts service.", 0, $ex);
        }
    }
}