<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 3:58 PM
 */

namespace RockBuzz\Post\Domain\Post;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use RockBuzz\Post\Domain\Author\AuthorEntity;
use RockBuzz\Post\Domain\Identifiable;
use RockBuzz\Post\Domain\Preconditions;
use RockBuzz\Post\Domain\Tag\TagEntity;

/**
 * @Entity
 * @Table(name="posts")
 */
class PostEntity implements Identifiable {

    /**
     * @var integer
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     * @Column(name="slug", type="string", length=100)
     */
    private $slug;

    /**
     * @var string
     * @Column(name="body", type="text")
     */
    private $body;

    /**
     * @var boolean
     * @Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var AuthorEntity
     * @ManyToOne(targetEntity="RockBuzz\Post\Domain\Author\AuthorEntity", fetch="EAGER")
     * @JoinColumn(name="author_id", nullable=false)
     */
    private $author;

    /**
     * @var ArrayCollection | TagEntity[]
     * @ManyToMany(targetEntity="RockBuzz\Post\Domain\Tag\TagEntity", cascade={"PERSIST", "MERGE"})
     * @JoinTable(name="post_tag",
     *     joinColumns={@JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id")})
     */
    private $tags;

    private function __construct($id, $title, $slug, $body, $published, $author, $tags) {
        $this->id        = $id;
        $this->title     = $title;
        $this->slug      = $slug;
        $this->body      = $body;
        $this->published = $published;
        $this->author    = $author;
        $this->tags      = new ArrayCollection($tags);
    }

    public static function create(?array $values): self {
        Preconditions::nonEmptyKey($values, "title", "Title is required");
        Preconditions::nonEmptyKey($values, "slug", "Slug is required");
        Preconditions::nonEmptyKey($values, "body", "Body is required");
        Preconditions::nonEmptyKey($values, "author", "Author is required");

        $published = $values["published"] ?: false;
        $tags      = $values["tags"] ?: [];

        return new self(null, $values["title"], $values["slug"], $values["body"], $published, $values["author"], $tags);
    }

    public function update(?array $values): self {
        $title     = $values["title"] ?: $this->title;
        $slug      = $values["slug"] ?: $this->slug;
        $body      = $values["body"] ?: $this->body;
        $published = $values["published"] ?: $this->published;
        $author    = $values["author"] ?: $this->author;
        $tags      = $values["tags"] ?: $this->tags;

        return new self($this->id, $title, $slug, $body, $published, $author, $tags);
    }

    /**
     * @return integer
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
     * @return AuthorEntity
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @return TagEntity[]
     */
    public function getTags() {
        if ($this->tags instanceof Collection) {
            return $this->tags->getValues();
        }
        return $this->tags;
    }

    public function __toString() {
        return "PostEntity " . json_encode([
                "id"        => $this->id,
                "title"     => $this->title,
                "slug"      => $this->slug,
                "body"      => $this->body,
                "published" => $this->published,
                "author"    => $this->author ? $this->author->__toString() : null,
                "tags"      => $this->tags->map(TagEntity::mapToString())
                    ->getValues(),
            ]);
    }
}