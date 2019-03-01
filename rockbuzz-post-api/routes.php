<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:17 PM
 */

use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use RockBuzz\Post\Domain\Author\AuthorRepository;
use RockBuzz\Post\Domain\Tag\TagRepository;
use RockBuzz\Post\Infrastructure\App\ParamToEntityConverterMiddlewareFactory;
use RockBuzz\Post\Infrastructure\OAuth2\ValidadeAuthorizationMiddleware;
use RockBuzz\Post\View\Author\AuthorRestController;
use RockBuzz\Post\View\Post\PostRestController;
use RockBuzz\Post\View\Tag\TagRestController;
use Slim\App;

$app->group("/api", function(App $app) use ($container) {
    /** @var ParamToEntityConverterMiddlewareFactory $converterFactory */
    $converterFactory = $container[ParamToEntityConverterMiddlewareFactory::class];

    $app->group("/authors", function(App $app) {
        $app->get("", AuthorRestController::class . ":findAll")
            ->setName("authors.findAll");

        $app->post("", AuthorRestController::class . ":insert")
            ->setName("authors.insert");

        $app->get("/{id}", AuthorRestController::class . ":findOne")
            ->setName("authors.findOne");

        $app->put("/{id}", AuthorRestController::class . ":update")
            ->setName("authors.update");

        $app->delete("/{id}", AuthorRestController::class . ":delete")
            ->setName("authors.delete");
    });

    $app->group("/tags", function(App $app) {
        $app->get("", TagRestController::class . ":findAll")
            ->setName("tags.findAll");

        $app->post("", TagRestController::class . ":insert")
            ->setName("tags.insert");

        $app->get("/{id}", TagRestController::class . ":findOne")
            ->setName("tags.findOne");

        $app->put("/{id}", TagRestController::class . ":update")
            ->setName("tags.update");

        $app->delete("/{id}", TagRestController::class . ":delete")
            ->setName("tags.delete");
    });

    $app->group("/posts", function(App $app) use ($converterFactory) {
        $authorConverter = $converterFactory->getInstance("author", AuthorRepository::class);
        $tagConverter    = $converterFactory->getInstance("tags", TagRepository::class);

        $app->get("", PostRestController::class . ":findAll")
            ->setName("posts.findAll");

        $app->post("", PostRestController::class . ":insert")
            ->setName("posts.insert")
            ->add($authorConverter)
            ->add($tagConverter);

        $app->get("/{id}", PostRestController::class . ":findOne")
            ->setName("posts.findOne");

        $app->put("/{id}", PostRestController::class . ":update")
            ->setName("posts.update")
            ->add($authorConverter)
            ->add($tagConverter);

        $app->delete("/{id}", PostRestController::class . ":delete")
            ->setName("posts.delete");

        $app->get("/slug/{slug}", PostRestController::class . ":findOneBySlug")
            ->setName("posts.findOneBySlug");
    });
})
    ->add($container[ValidadeAuthorizationMiddleware::class])
    ->add($container[ResourceServerMiddleware::class]);
