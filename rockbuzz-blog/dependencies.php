<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:14 PM
 */

use Pimple\Container;
use RockBuzz\Blog\Domain\Author\AuthorRepository;
use RockBuzz\Blog\Domain\Post\PostRepository;
use RockBuzz\Blog\Domain\Tag\TagRepository;

$container[AuthorRepository::class] = function(Container $container) {
    return new AuthorRepository($container);
};

$container[TagRepository::class] = function(Container $container) {
    return new TagRepository($container);
};

$container[PostRepository::class] = function(Container $container) {
    return new PostRepository($container);
};