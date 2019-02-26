<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 5:10 PM
 */

namespace RockBuzz\Post\View\Author;

use RockBuzz\Post\Domain\Author\AuthorEntity;
use Slim\Http\Request;

class AuthorResource {

    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    private function __construct(AuthorEntity $author) {
        $this->id   = $author->getId();
        $this->name = $author->getName();
    }

    /**
     * @param Request $request
     * @param AuthorEntity $author
     * @return self
     */
    public static function single(Request $request, AuthorEntity $author) {
        return new self($author);
    }

    /**
     * @param Request $request
     * @param AuthorEntity[] $authors
     * @return self[]
     */
    public static function collection(Request $request, array $authors) {
        return array_map(function(AuthorEntity $author) use ($request) {
            return self::single($request, $author);
        }, $authors);
    }
}