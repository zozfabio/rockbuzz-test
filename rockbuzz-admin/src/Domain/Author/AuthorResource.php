<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 2:51 PM
 */

namespace RockBuzz\Admin\Domain\Author;

use stdClass;

class AuthorResource {

    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    private function __construct(stdClass $author) {
        $this->id   = $author->id;
        $this->name = $author->name;
    }

    public static function single(stdClass $author): self {
        return new self($author);
    }

    public static function collection(array $authors): array {
        return array_map(function(stdClass $author) {
            return self::single($author);
        }, $authors);
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