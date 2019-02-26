<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 3:18 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\User;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * @Entity
 * @Table(name="user")
 */
class UserEntity implements UserEntityInterface {

    /**
     * @var integer
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $password;

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdentifier() {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }
}