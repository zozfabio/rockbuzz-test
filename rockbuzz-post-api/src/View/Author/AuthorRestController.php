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
use RockBuzz\Post\Domain\Author\AuthorEntity;
use RockBuzz\Post\Domain\Author\AuthorRepository;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class AuthorRestController {

    /** @var Logger */
    private $logger;

    /** @var Router */
    private $router;

    /** @var AuthorRepository */
    private $authors;

    public function __construct(Container $container) {
        $this->logger  = $container[Logger::class];
        $this->router  = $container["router"];
        $this->authors = $container[AuthorRepository::class];
    }

    public function findAll(Request $request, Response $response) {
        $authors         = $this->authors->findAll();
        $authorResources = AuthorResource::collection($request, $authors);
        return $response->withJson($authorResources);
    }

    public function findOne(Request $request, Response $response, array $args) {
        $author         = $this->authors->findOne($args["id"]);
        $authorResource = AuthorResource::single($request, $author);
        return $response->withJson($authorResource);
    }

    public function insert(Request $request, Response $response) {
        $author = AuthorEntity::create($request->getParams());

        $this->authors->save($author);

        $authorResource = AuthorResource::single($request, $author);
        return $response->withStatus(201)
            ->withAddedHeader("Location", $this->router->pathFor("authors.findOne", ["id" => $author->getId()]))
            ->withJson($authorResource);
    }

    public function update(Request $request, Response $response, array $args) {
        $author = $this->authors->findOne($args["id"]);

        $author = $this->authors->save($author->update($request->getParams()));

        $authorResource = AuthorResource::single($request, $author);
        return $response->withJson($authorResource);
    }

    public function delete(Request $request, Response $response, array $args) {
        $author = $this->authors->findOne($args["id"]);

        $this->authors->delete($author);
    }
}