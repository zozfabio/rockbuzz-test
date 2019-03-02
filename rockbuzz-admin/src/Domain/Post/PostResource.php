<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 2:50 PM
 */

namespace RockBuzz\Admin\Domain\Post;

use RockBuzz\Admin\Domain\Author\AuthorResource;
use RockBuzz\Admin\Domain\Preconditions;
use RockBuzz\Admin\Domain\Tag\TagResource;
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

    /** @var boolean */
    private $published;

    /** @var AuthorResource */
    private $author;

    /** @var TagResource[] */
    private $tags;

    private function __construct(stdClass $post, ?AuthorResource $author, array $tags) {
        $this->id        = $post->id;
        $this->title     = $post->title;
        $this->slug      = $post->slug;
        $this->body      = $post->body;
        $this->published = $post->published;
        $this->author    = $author;
        $this->tags      = $tags;
    }

    public static function single(stdClass $post): self {
        $author = AuthorResource::single($post->author);
        $tags   = TagResource::collection($post->tags);

        return new self($post, $author, $tags);
    }

    public static function collection(array $posts): array {
        return array_map(function(stdClass $post) {
            return self::single($post);
        }, $posts);
    }

    public static function create(array $post): array {
        Preconditions::nonEmptyKey($post, "title", "Title is required");
        Preconditions::nonEmptyKey($post, "slug", "Slug is required");
        Preconditions::nonEmptyKey($post, "body", "Body is required");
        Preconditions::nonEmptyKey($post, "author", "Author is required");
        Preconditions::nonEmptyKey($post, "tags", "At least one Tag is required");

        $post["published"] = (bool)(($post["published"] ?: false));

        return [
            "title"     => $post["title"],
            "slug"      => $post["slug"],
            "body"      => $post["body"],
            "author"    => $post["author"],
            "published" => $post["published"],
            "tags"      => $post["tags"],
        ];
    }

    public function update(array $post): array {
        Preconditions::nonEmptyKey($post, "title", "Title is required");
        Preconditions::nonEmptyKey($post, "slug", "Slug is required");
        Preconditions::nonEmptyKey($post, "body", "Body is required");
        Preconditions::nonEmptyKey($post, "author", "Author is required");
        Preconditions::nonEmptyKey($post, "tags", "At least one Tag is required");

        $post["published"] = (bool)(($post["published"] ?: false));

        return [
            "id"        => $this->id,
            "title"     => $post["title"],
            "slug"      => $post["slug"],
            "body"      => $post["body"],
            "author"    => $post["author"],
            "published" => $post["published"],
            "tags"      => $post["tags"],
        ];
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
     * @return boolean
     */
    public function isPublished() {
        return $this->published;
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
}