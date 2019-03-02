<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 2:50 PM
 */

namespace RockBuzz\Admin\Domain\Author;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pimple\Container;
use RockBuzz\Admin\Domain\RepositoryException;
use RockBuzz\Admin\Domain\RequestFactory;

class AuthorRepository {

    /** @var Client */
    private $client;

    /** @var RequestFactory */
    private $requestFactory;

    public function __construct(Container $container) {
        $this->client         = $container[Client::class];
        $this->requestFactory = $container[RequestFactory::class];
    }

    /**
     * @return AuthorResource[]
     */
    public function findAll(): array {
        $request = $this->requestFactory->getInstance("GET", "/api/authors");

        try {
            $response = $this->client->send($request);
            return AuthorResource::collection(json_decode($response->getBody()
                ->getContents()));
        } catch (GuzzleException $ex) {
            throw new RepositoryException("Failed to retrieve authors from posts service.", 0, $ex);
        }
    }
}