<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 2:11 PM
 */

namespace RockBuzz\Admin\View;

use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Admin\Domain\Author\AuthorRepository;
use RockBuzz\Admin\Domain\InvalidValueException;
use RockBuzz\Admin\Domain\Post\PostRepository;
use RockBuzz\Admin\Domain\Post\PostResource;
use RockBuzz\Admin\Domain\Tag\TagRepository;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class PostsController {

    /** @var Logger */
    private $logger;

    /** @var Router */
    private $router;

    /** @var PhpRenderer */
    private $views;

    /** @var AuthorRepository */
    private $authors;

    /** @var TagRepository */
    private $tags;

    /** @var PostRepository */
    private $posts;

    public function __construct(Container $container) {
        $this->logger  = $container[Logger::class];
        $this->router  = $container["router"];
        $this->views   = $container[PhpRenderer::class];
        $this->authors = $container[AuthorRepository::class];
        $this->tags    = $container[TagRepository::class];
        $this->posts   = $container[PostRepository::class];
    }

    public function findAll(Request $request, Response $response) {
        return $this->views->render($response, "/posts.php", [
            "router"  => $this->router,
            "message" => $request->getParam("m"),

            "authors" => $this->authors->findAll(),
            "tags"    => $this->tags->findAll(),
            "posts"   => $this->posts->findAll(),
        ]);
    }

    public function findOne(Request $request, Response $response, array $args) {
        return $this->views->render($response, "/posts.php", [
            "router"  => $this->router,
            "message" => $request->getParam("m"),

            "authors"  => $this->authors->findAll(),
            "tags"     => $this->tags->findAll(),
            "posts"    => $this->posts->findAll(),
            "selected" => $this->posts->findOne($args["id"]),
        ]);
    }

    public function doInsert(Request $request, Response $response) {
        $formData = $request->getParams();

        try {
            $postData = PostResource::create($formData);

            $this->posts->save($postData);

            return $response->withRedirect($this->router->pathFor("posts.findAll", [], [
                "m" => "Post inserted.",
            ]));
        } catch (InvalidValueException $ex) {
            return $this->views->render($response, "/posts.php", [
                "router"    => $this->router,
                "formError" => $ex->getMessage(),
                "formData"  => $formData,

                "authors" => $this->authors->findAll(),
                "tags"    => $this->tags->findAll(),
                "posts"   => $this->posts->findAll(),
            ]);
        }
    }

    public function doUpdate(Request $request, Response $response, array $args) {
        $post     = $this->posts->findOne($args["id"]);
        $formData = $request->getParams();

        try {
            $postData = $post->update($formData);

            $this->posts->save($postData);

            return $response->withRedirect($this->router->pathFor("posts.findOne", ["id" => $post->getId()], [
                "m" => "Post updated.",
            ]));
        } catch (InvalidValueException $ex) {
            return $this->views->render($response, "/posts.php", [
                "router"    => $this->router,
                "formError" => $ex->getMessage(),
                "formData"  => $formData,

                "authors"  => $this->authors->findAll(),
                "tags"     => $this->tags->findAll(),
                "posts"    => $this->posts->findAll(),
                "selected" => $post,
            ]);
        }
    }
}