<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 7:27 PM
 */

namespace RockBuzz\Blog\View;

use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Blog\Domain\Author\AuthorRepository;
use RockBuzz\Blog\Domain\Post\PostRepository;
use RockBuzz\Blog\Domain\RepositoryException;
use RockBuzz\Blog\Domain\Tag\TagRepository;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class HomeAction {

    use ActionHasAuthorsCard, ActionHasTagsCard, ActionHasCurrentFilterCard;

    /** @var Logger */
    private $logger;

    /** @var Router */
    private $router;

    /** @var PhpRenderer */
    private $views;

    /** @var PostRepository */
    private $posts;

    /** @var AuthorRepository */
    private $authors;

    /** @var TagRepository */
    private $tags;

    public function __construct(Container $container) {
        $this->logger  = $container[Logger::class];
        $this->router  = $container["router"];
        $this->views   = $container[PhpRenderer::class];
        $this->authors = $container[AuthorRepository::class];
        $this->tags    = $container[TagRepository::class];
        $this->posts   = $container[PostRepository::class];
    }

    public function __invoke(Request $request, Response $response) {
        $currParams = $request->getQueryParams();

        $allAuthors = $this->authors->findAll();
        $allTags    = $this->tags->findAll();

        try {
            $this->views->render($response, "/home.php", [
                "router"     => $this->router,
                "currParams" => $currParams,

                "filter"            => [
                    "a" => $this->buildAuthorFilter($currParams, $allAuthors),
                    "t" => $this->buildTagFilter($currParams, $allTags),
                ],
                "filterAuthorRoute" => $this->filterAuthorRoute($currParams),
                "filterTagRoute"    => $this->filterTagRoute($currParams),

                "removeFilterAuthorRoute" => $this->removeFilterAuthorRoute($currParams),
                "removeFilterTagRoute"    => $this->removeFilterTagRoute($currParams),

                "authors" => $this->removeAuthorsFiltered($allAuthors, $currParams),
                "tags"    => $this->removeTagsFiltered($allTags, $currParams),
                "posts"   => $this->posts->findAll($currParams),
            ]);
        } catch (RepositoryException $ex) {
            $response->write($ex->getMessage());
        }
    }
}