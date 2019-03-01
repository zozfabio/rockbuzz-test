<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 7:33 PM
 */

namespace RockBuzz\Post\View\Post;

use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Post\Domain\Arguments\ArgumentEquals;
use RockBuzz\Post\Domain\Post\PostEntity;
use RockBuzz\Post\Domain\Post\PostRepository;
use RockBuzz\Post\View\ControllerArgument;
use RockBuzz\Post\View\ControllerHasArguments;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class PostRestController {

    use ControllerHasArguments;

    /** @var Logger */
    private $logger;

    /** @var Router */
    private $router;

    /** @var PostRepository */
    private $posts;

    public function __construct(Container $container) {
        $this->logger = $container[Logger::class];
        $this->router = $container["router"];
        $this->posts  = $container[PostRepository::class];
    }

    public function getArguments() {
        return [
            ControllerArgument::of("a", ArgumentEquals::class, "author.id"),
            ControllerArgument::of("t", ArgumentEquals::class, "tag.id"),
        ];
    }

    public function findAll(Request $request, Response $response) {
        $arguments     = $this->getArgumentsFromRequest($request);
        $posts         = $this->posts->findAll($arguments);
        $postResources = PostResource::collection($request, $posts);
        return $response->withJson($postResources);
    }

    public function findOne(Request $request, Response $response, array $args) {
        $post         = $this->posts->findOne($args["id"]);
        $postResource = PostResource::single($request, $post);
        return $response->withJson($postResource);
    }

    public function findOneBySlug(Request $request, Response $response, array $args) {
        $post         = $this->posts->findOneBySlug($args["slug"]);
        $postResource = PostResource::single($request, $post);
        return $response->withJson($postResource);
    }

    public function insert(Request $request, Response $response) {
        $post = PostEntity::create($request->getParams());

        $this->posts->save($post);

        $postResource = PostResource::single($request, $post);
        return $response->withStatus(201)
            ->withAddedHeader("Location", $this->router->pathFor("posts.findOne", ["id" => $post->getId()]))
            ->withJson($postResource);
    }

    public function update(Request $request, Response $response, array $args) {
        $post = $this->posts->findOne($args["id"]);

        $post = $this->posts->save($post->update($request->getParams()));

        $postResource = PostResource::single($request, $post);
        return $response->withJson($postResource);
    }

    public function delete(Request $request, Response $response, array $args) {
        $post = $this->posts->findOne($args["id"]);

        $this->posts->delete($post);
    }
}