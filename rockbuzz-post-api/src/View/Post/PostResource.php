<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 7:34 PM
 */

namespace RockBuzz\Post\View\Post;

use JsonSerializable;
use RockBuzz\Post\Domain\Post\PostEntity;
use RockBuzz\Post\View\Author\AuthorResource;
use RockBuzz\Post\View\Tag\TagResource;
use Slim\Http\Request;

class PostResource implements JsonSerializable {

    private $id;

    private $title;

    private $slug;

    private $body;

    private $published;

    private $author;

    private $tags;

    private function __construct(PostEntity $post, ?bool $published, ?AuthorResource $author, ?array $tags) {
        $this->id        = $post->getId();
        $this->title     = $post->getTitle();
        $this->slug      = $post->getSlug();
        $this->body      = $post->getBody();
        $this->published = $published;
        $this->author    = $author;
        $this->tags      = $tags;
    }

    /**
     * @param Request $request
     * @param PostEntity $post
     * @return self
     */
    public static function single(Request $request, PostEntity $post) {
        /** @var array $scopes */
        $scopes = $request->getAttribute("oauth_scopes");

        $author = null;
        if (array_search("posts.author", $scopes) !== false) {
            $author = AuthorResource::single($request, $post->getAuthor());
        }

        $tags = null;
        if (array_search("posts.tags", $scopes) !== false) {
            $tags = TagResource::collection($request, $post->getTags());
        }

        $published = null;
        if (array_search("posts.published", $scopes)) {
            $published = $post->isPublished();
        }

        return new self($post, $published, $author, $tags);
    }

    /**
     * @param Request $request
     * @param PostEntity[] $posts
     * @return self[]
     */
    public static function collection(Request $request, array $posts) {
        return array_map(function(PostEntity $post) use ($request) {
            return self::single($request, $post);
        }, $posts);
    }

    public function jsonSerialize() {
        $json = [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "body" => $this->body,
        ];

        if (!is_null($this->published)) {
            $json["published"] = $this->published;
        }
        if (!is_null($this->author)) {
            $json["author"] = $this->author;
        }
        if (!is_null($this->tags)) {
            $json["tags"] = $this->tags;
        }

        return $json;
    }
}