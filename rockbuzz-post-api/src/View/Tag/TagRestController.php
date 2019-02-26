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
use RockBuzz\Post\Domain\Tag\TagRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class TagRestController {

    /** @var Logger */
    private $logger;

    /** @var TagRepository */
    private $tags;

    public function __construct(Container $container) {
        $this->logger = $container[Logger::class];
        $this->tags   = $container[TagRepository::class];
    }

    public function findAll(Request $request, Response $response) {
        $tags         = $this->tags->findAll();
        $tagResources = TagResource::collection($request, $tags);
        return $response->withJson($tagResources);
    }
}