<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 7:29 PM
 */

namespace RockBuzz\Post\View\Tag;

use RockBuzz\Post\Domain\Tag\TagEntity;
use Slim\Http\Request;

class TagResource {

    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    private function __construct(TagEntity $tag) {
        $this->id   = $tag->getId();
        $this->name = $tag->getName();
    }

    /**
     * @param Request $request
     * @param TagEntity $tag
     * @return self
     */
    public static function single(Request $request, TagEntity $tag) {
        return new self($tag);
    }

    /**
     * @param Request $request
     * @param TagEntity[] $tags
     * @return self[]
     */
    public static function collection(Request $request, array $tags) {
        return array_map(function(TagEntity $tag) use ($request) {
            return self::single($request, $tag);
        }, $tags);
    }
}