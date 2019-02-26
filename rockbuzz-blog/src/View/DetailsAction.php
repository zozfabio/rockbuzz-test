<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 7:27 PM
 */

namespace RockBuzz\Blog\View;

use Pimple\Container;
use RockBuzz\Blog\Domain\Post\PostRepository;
use RockBuzz\Blog\Domain\RepositoryException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class DetailsAction {

    /** @var Router */
    private $router;

    /** @var PhpRenderer */
    private $views;

    /** @var PostRepository */
    private $posts;

    public function __construct(Container $container) {
        $this->router = $container["router"];
        $this->views  = $container[PhpRenderer::class];
        $this->posts  = $container[PostRepository::class];
    }

    public function __invoke(Request $request, Response $response, array $args) {
        try {
            $this->views->render($response, "/details.php", [
                "router" => $this->router,
                "post"   => $this->posts->findOneBySlug($args["slug"]),
            ]);
        } catch (RepositoryException $ex) {
            $response->write($ex->getMessage());
        }
    }
}