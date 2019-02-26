<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:17 PM
 */

use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use RockBuzz\Post\Infrastructure\OAuth2\ValidadeAuthorizationMiddleware;
use RockBuzz\Post\View\Author\AuthorRestController;
use RockBuzz\Post\View\Post\PostRestController;
use RockBuzz\Post\View\Tag\TagRestController;

$app->group("/api", function() use ($app) {
    $app->get("/authors", AuthorRestController::class . ":findAll")
        ->setName("authors.findAll");

    $app->get("/tags", TagRestController::class . ":findAll")
        ->setName("tags.findAll");

    $app->get("/posts", PostRestController::class . ":findAll")
        ->setName("posts.findAll");
    $app->get("/posts/slug/{slug}", PostRestController::class . ":findOneBySlug")
        ->setName("posts.findOneBySlug");
})->add($container[ValidadeAuthorizationMiddleware::class])
    ->add($container[ResourceServerMiddleware::class]);
