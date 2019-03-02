<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:14 PM
 */

use Pimple\Container;
use RockBuzz\Admin\Domain\Author\AuthorRepository;
use RockBuzz\Admin\Domain\Post\PostRepository;
use RockBuzz\Admin\Domain\Tag\TagRepository;
use RockBuzz\Admin\View\LoginController;
use RockBuzz\Admin\View\PostsController;

$container[AuthorRepository::class] = function(Container $container) {
    return new AuthorRepository($container);
};

$container[TagRepository::class] = function(Container $container) {
    return new TagRepository($container);
};

$container[LoginController::class] = function(Container $container) {
    return new LoginController($container);
};

$container[PostRepository::class] = function(Container $container) {
    return new PostRepository($container);
};
$container[PostsController::class] = function(Container $container) {
    return new PostsController($container);
};