<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 10:08 AM
 */

namespace RockBuzz\Blog\Domain\Post;

use RockBuzz\Blog\Domain\Author\AuthorResource;
use RockBuzz\Blog\Domain\Tag\TagResource;
use stdClass;

class PostResource {

    /** @var integer */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $slug;

    /** @var string */
    private $body;

    /** @var AuthorResource */
    private $author;

    /** @var TagResource[] */
    private $tags;

    private function __construct(stdClass $post, ?AuthorResource $author, array $tags) {
        $this->id     = $post->id;
        $this->title  = $post->title;
        $this->slug   = $post->slug;
        $this->body   = $post->body;
        $this->author = $author;
        $this->tags   = $tags;
    }

    public static function single(stdClass $post): self {
        $author = null;
        if (isset($post->author) && !is_null($post->author)) {
            $author = AuthorResource::single($post->author);
        }

        $tags = [];
        if (isset($post->tags) && !is_null($post->tags)) {
            $tags = TagResource::collection($post->tags);
        }

        return new self($post, $author, $tags);
    }

    public static function collection(array $posts): array {
        return array_map(function(stdClass $post) {
            return self::single($post);
        }, $posts);
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
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return AuthorResource
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @return TagResource[]
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getSummary() {
        $plainTextBody = strip_tags($this->body);
        $paragraphs = explode("\n", $plainTextBody);
        if (sizeof($paragraphs) > 1) {
            return $paragraphs[0];
        }
        $parts = explode(".", $plainTextBody);
        if (sizeof($parts) > 0) {
            return $parts[0] . ".";
        }
        return $plainTextBody;
    }
}