<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 3:49 PM
 */

namespace RockBuzz\Post\Domain\Author;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="authors")
 */
class AuthorEntity {

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

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function __toString() {
        return "AuthorEntity " . json_encode([
                "id"   => $this->id,
                "name" => $this->name,
            ]);
    }
}