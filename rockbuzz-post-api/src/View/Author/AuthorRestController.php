<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 5:06 PM
 */

namespace RockBuzz\Post\View\Author;

use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Post\Domain\Author\AuthorRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorRestController {

    /** @var Logger */
    private $logger;

    /** @var AuthorRepository */
    private $authors;

    public function __construct(Container $container) {
        $this->logger  = $container[Logger::class];
        $this->authors = $container[AuthorRepository::class];
    }

    public function findAll(Request $request, Response $response) {
        $authors         = $this->authors->findAll();
        $authorResources = AuthorResource::collection($request, $authors);
        return $response->withJson($authorResources);
    }
}