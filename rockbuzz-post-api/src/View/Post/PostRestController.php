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
use RockBuzz\Post\Domain\Post\PostRepository;
use RockBuzz\Post\View\ControllerArgument;
use RockBuzz\Post\View\ControllerHasArguments;
use Slim\Http\Request;
use Slim\Http\Response;

class PostRestController {

    use ControllerHasArguments;

    /** @var Logger */
    private $logger;

    /** @var PostRepository */
    private $posts;

    public function __construct(Container $container) {
        $this->logger = $container[Logger::class];
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

    public function findOneBySlug(Request $request, Response $response, array $args) {
        $post         = $this->posts->findOneBySlug($args["slug"]);
        $postResource = PostResource::single($request, $post);
        return $response->withJson($postResource);
    }
}