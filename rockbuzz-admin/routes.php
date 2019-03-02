<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:15 PM
 */

use RockBuzz\Admin\Infrastructure\Guzzle\RequestFactoryRegisterMiddleware;
use RockBuzz\Admin\Infrastructure\OAuth2\AuthorizationMiddleware;
use RockBuzz\Admin\View\LoginController;
use RockBuzz\Admin\View\PostsController;
use Slim\App;

// Public routes
$app->get("/login", LoginController::class . ":login")
    ->setName("login.get");

$app->post("/login", LoginController::class . ":doLogin")
    ->setName("login.post");

$app->get("/logout", LoginController::class . ":doLogout")
    ->setName("logout");

// Protected routes
$app->group("/", function(App $app) {
    $app->get("", PostsController::class . ":findAll");
    $app->get("posts", PostsController::class . ":findAll")
        ->setName("posts.findAll");

    $app->get("posts/{id:[0-9]+}", PostsController::class . ":findOne")
        ->setName("posts.findOne");

    $app->post("posts/insert", PostsController::class . ":doInsert")
        ->setName("posts.insert");

    $app->post("posts/{id:[0-9]+}/update", PostsController::class . ":doUpdate")
        ->setName("posts.update");
})
    ->add($container[RequestFactoryRegisterMiddleware::class])
    ->add($container[AuthorizationMiddleware::class]);