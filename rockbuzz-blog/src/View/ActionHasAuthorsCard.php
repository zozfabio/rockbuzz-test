<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 9:11 PM
 */

namespace RockBuzz\Blog\View;

use RockBuzz\Blog\Domain\Author\AuthorResource;
use Slim\Router;

trait ActionHasAuthorsCard {

    private function filterAuthorRoute(array $currParams): callable {
        return function(AuthorResource $author) use ($currParams) {
            if ($this->router instanceof Router) {
                if (isset($currParams["a"])) {
                    return $this->router->pathFor("posts.findAll", [],
                        array_merge($currParams, ["a" => array_merge($currParams["a"], [$author->getId()])]));
                }
                return $this->router->pathFor("posts.findAll", [],
                    array_merge($currParams, ["a" => [$author->getId()]]));
            }
            return "";
        };
    }

    private function removeAuthorsFiltered(array $allAuthors, array $currParams): array {
        return array_filter($allAuthors, function(AuthorResource $author) use ($currParams) {
            return !isset($currParams["a"]) || !in_array($author->getId(), $currParams["a"]);
        }, ARRAY_FILTER_USE_BOTH);
    }
}