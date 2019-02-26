<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 9:21 PM
 */

namespace RockBuzz\Blog\View;

use RockBuzz\Blog\Domain\Tag\TagResource;
use Slim\Router;

trait ActionHasTagsCard {

    private function filterTagRoute(array $currParams) {
        return function(TagResource $tag) use ($currParams) {
            if ($this->router instanceof Router) {
                if (isset($currParams["t"])) {
                    return $this->router->pathFor("posts.findAll", [],
                        array_merge_recursive($currParams, ["t" => array_merge($currParams["t"], [$tag->getId()])]));
                }
                return $this->router->pathFor("posts.findAll", [],
                    array_merge_recursive($currParams, ["t" => [$tag->getId()]]));
            }
            return "";
        };
    }

    private function removeTagsFiltered(array $allTags, array $currParams): array {
        return array_filter($allTags, function(TagResource $tag) use ($currParams) {
            return !isset($currParams["t"]) || !in_array($tag->getId(), $currParams["t"]);
        }, ARRAY_FILTER_USE_BOTH);
    }
}