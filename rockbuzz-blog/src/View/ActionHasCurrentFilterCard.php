<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 9:16 PM
 */

namespace RockBuzz\Blog\View;

use RockBuzz\Blog\Domain\Author\AuthorResource;
use RockBuzz\Blog\Domain\Tag\TagResource;
use Slim\Router;

trait ActionHasCurrentFilterCard {

    private function buildAuthorFilter(array $currParams, array $allAuthors): array {
        return array_filter($allAuthors, function(AuthorResource $author) use ($currParams) {
            return isset($currParams["a"]) && in_array($author->getId(), $currParams["a"]);
        }, ARRAY_FILTER_USE_BOTH);
    }

    private function buildTagFilter(array $currParams, array $allTags): array {
        return array_filter($allTags, function(TagResource $tag) use ($currParams) {
            return isset($currParams["t"]) && in_array($tag->getId(), $currParams["t"]);
        }, ARRAY_FILTER_USE_BOTH);
    }

    private function removeFilterAuthorRoute(array $currParams) {
        return function(AuthorResource $author) use ($currParams) {
            if ($this->router instanceof Router) {
                $newA   = array_filter($currParams["a"], function($authorParam) use ($author) {
                    return $authorParam != $author->getId();
                }, ARRAY_FILTER_USE_BOTH);
                $params = array_merge($currParams, ["a" => $newA]);
                return $this->router->pathFor("posts.findAll", [], $params);
            }
            return "";
        };
    }

    private function removeFilterTagRoute(array $currParams) {
        return function(TagResource $tag) use ($currParams) {
            if ($this->router instanceof Router) {
                $newT   = array_filter($currParams["t"], function($tagParam) use ($tag) {
                    return $tagParam != $tag->getId();
                }, ARRAY_FILTER_USE_BOTH);
                $params = array_merge($currParams, ["t" => $newT]);
                return $this->router->pathFor("posts.findAll", [], $params);
            }
            return "";
        };
    }
}