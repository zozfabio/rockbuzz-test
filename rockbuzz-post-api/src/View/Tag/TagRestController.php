<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 7:28 PM
 */

namespace RockBuzz\Post\View\Tag;

use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Post\Domain\Tag\TagEntity;
use RockBuzz\Post\Domain\Tag\TagRepository;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class TagRestController {

    /** @var Logger */
    private $logger;

    /** @var Router */
    private $router;

    /** @var TagRepository */
    private $tags;

    public function __construct(Container $container) {
        $this->logger = $container[Logger::class];
        $this->router  = $container["router"];
        $this->tags   = $container[TagRepository::class];
    }

    public function findAll(Request $request, Response $response) {
        $tags         = $this->tags->findAll();
        $tagResources = TagResource::collection($request, $tags);
        return $response->withJson($tagResources);
    }

    public function findOne(Request $request, Response $response, array $args) {
        $tag         = $this->tags->findOne($args["id"]);
        $tagResource = TagResource::single($request, $tag);
        return $response->withJson($tagResource);
    }

    public function insert(Request $request, Response $response) {
        $tag = TagEntity::create($request->getParams());

        $this->tags->save($tag);

        $tagResource = TagResource::single($request, $tag);
        return $response->withStatus(201)
            ->withAddedHeader("Location", $this->router->pathFor("tags.findOne", ["id" => $tag->getId()]))
            ->withJson($tagResource);
    }

    public function update(Request $request, Response $response, array $args) {
        $tag = $this->tags->findOne($args["id"]);

        $tag = $this->tags->save($tag->update($request->getParams()));

        $tagResource = TagResource::single($request, $tag);
        return $response->withJson($tagResource);
    }

    public function delete(Request $request, Response $response, array $args) {
        $tag = $this->tags->findOne($args["id"]);

        $this->tags->delete($tag);
    }
}