<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 2:52 PM
 */

namespace RockBuzz\Admin\Domain\Tag;

use stdClass;

class TagResource {

    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    private function __construct(stdClass $tag) {
        $this->id   = $tag->id;
        $this->name = $tag->name;
    }

    public static function single(stdClass $tag): self {
        return new self($tag);
    }

    public static function collection(array $tags): array {
        return array_map(function(stdClass $tag) {
            return self::single($tag);
        }, $tags);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}