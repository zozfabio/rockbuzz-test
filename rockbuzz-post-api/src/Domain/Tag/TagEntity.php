<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 3:56 PM
 */

namespace RockBuzz\Post\Domain\Tag;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use RockBuzz\Post\Domain\Identifiable;
use RockBuzz\Post\Domain\Preconditions;

/**
 * @Entity
 * @Table(name="tags")
 */
class TagEntity implements Identifiable {

    /**
     * @var integer
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(name="name", type="string", length=45)
     */
    private $name;

    private function __construct($id, $name) {
        $this->id   = $id;
        $this->name = $name;
    }

    public static function create(?array $values): self {
        Preconditions::nonEmptyKey($values, "name", "Name is required");

        return new self(null, $values["name"]);
    }

    public function update(?array $values): self {
        $name = $values["name"] ?: $this->name;

        return new self($this->id, $name);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function __toString() {
        return "TagEntity " . json_encode([
                "id"   => $this->id,
                "name" => $this->name,
            ]);
    }

    public static function mapToString() {
        return function(TagEntity $tag) {
            return $tag->__toString();
        };
    }
}