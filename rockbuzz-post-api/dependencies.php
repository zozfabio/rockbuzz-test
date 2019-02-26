<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:57 PM
 */

use Pimple\Container;
use RockBuzz\Post\Domain\Author\AuthorRepository;
use RockBuzz\Post\Domain\Post\PostRepository;
use RockBuzz\Post\Domain\Tag\TagRepository;
use RockBuzz\Post\View\Author\AuthorRestController;
use RockBuzz\Post\View\Post\PostRestController;
use RockBuzz\Post\View\Tag\TagRestController;

$container = $app->getContainer();

$container[AuthorRepository::class]     = function(Container $container) {
    return new AuthorRepository($container);
};
$container[AuthorRestController::class] = function(Container $container) {
    return new AuthorRestController($container);
};

$container[TagRepository::class]     = function(Container $container) {
    return new TagRepository($container);
};
$container[TagRestController::class] = function(Container $container) {
    return new TagRestController($container);
};

$container[PostRepository::class]     = function(Container $container) {
    return new PostRepository($container);
};
$container[PostRestController::class] = function(Container $container) {
    return new PostRestController($container);
};
