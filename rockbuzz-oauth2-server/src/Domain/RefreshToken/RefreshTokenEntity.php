<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 7:45 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\RefreshToken;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use RockBuzz\OAuth2\Server\Domain\AccessToken\AccessTokenEntity;

/**
 * @Entity
 * @Table(name="refresh_token")
 */
class RefreshTokenEntity implements RefreshTokenEntityInterface {

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
    private $identifier;

    /**
     * @var DateTime
     * @Column(type="datetime", nullable=false)
     */
    private $expires;

    /**
     * @var AccessTokenEntity
     * @ManyToOne(targetEntity="RockBuzz\OAuth2\Server\Domain\AccessToken\AccessTokenEntity", fetch="EAGER")
     * @JoinColumn(name="access_token_id", nullable=false)
     */
    private $accessToken;

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
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;
    }

    /**
     * @return DateTime
     */
    public function getExpires() {
        return $this->expires;
    }

    /**
     * @param DateTime $expires
     */
    public function setExpires($expires) {
        $this->expires = $expires;
    }

    /**
     * @return DateTime
     */
    public function getExpiryDateTime() {
        return $this->expires;
    }

    /**
     * @param DateTime $expiryDateTime
     */
    public function setExpiryDateTime($expiryDateTime) {
        $this->expires = $expiryDateTime;
    }

    /**
     * @return AccessTokenEntity
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * @param AccessTokenEntity $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }
}