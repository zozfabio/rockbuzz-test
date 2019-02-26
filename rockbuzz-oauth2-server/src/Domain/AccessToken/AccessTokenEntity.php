<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 5:23 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\AccessToken;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use RockBuzz\OAuth2\Server\Domain\Client\ClientEntity;
use RockBuzz\OAuth2\Server\Domain\Scope\ScopeEntity;
use RockBuzz\OAuth2\Server\Domain\User\UserEntity;

/**
 * @Entity
 * @Table(name="access_token")
 */
class AccessTokenEntity implements AccessTokenEntityInterface {

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
     * @var UserEntity
     * @ManyToOne(targetEntity="RockBuzz\OAuth2\Server\Domain\User\UserEntity", fetch="EAGER")
     * @JoinColumn(name="user_id")
     */
    private $user;

    /**
     * @var ClientEntity
     * @ManyToOne(targetEntity="RockBuzz\OAuth2\Server\Domain\Client\ClientEntity", fetch="EAGER")
     * @JoinColumn(name="client_id", nullable=false)
     */
    private $client;

    /**
     * @var ArrayCollection | ScopeEntity[]
     * @ManyToMany(targetEntity="RockBuzz\OAuth2\Server\Domain\Scope\ScopeEntity", cascade={"ALL"}, orphanRemoval=true)
     * @JoinTable(name="access_token_scopes",
     *     joinColumns={@JoinColumn(name="access_token_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")})
     */
    private $scopes;

    public function __construct() {
        $this->scopes = new ArrayCollection();
    }

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
     * @return UserEntity
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param UserEntity $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getUserIdentifier() {
        return $this->user->getIdentifier();
    }

    /**
     * @param integer $userIdentifier
     */
    public function setUserIdentifier($userIdentifier) {
    }

    /**
     * @return ClientEntity
     */
    public function getClient() {
        return $this->client;
    }

    /**
     * @param ClientEntity $client
     */
    public function setClient($client) {
        $this->client = $client;
    }

    /**
     * @return ScopeEntity[]
     */
    public function getScopes() {
        return $this->scopes->getValues();
    }

    /**
     * @param ArrayCollection | ScopeEntity[] $scopes
     */
    public function setScopes($scopes) {
        $this->scopes = $scopes;
    }

    /**
     * @param ScopeEntity $scope
     */
    public function addScope($scope) {
        $this->scopes->add($scope);
    }

    /**
     * Generate a JWT from the access token
     *
     * @param CryptKey $privateKey
     *
     * @return Token
     */
    public function convertToJWT(CryptKey $privateKey) {
        $jwtBuilder = new Builder();

        $jwtBuilder->setId($this->getIdentifier(), true);

        $jwtBuilder->setIssuedAt(time());
        $jwtBuilder->setNotBefore(time());
        $jwtBuilder->setExpiration($this->getExpiryDateTime()
            ->getTimestamp());

        $jwtBuilder->setAudience($this->getClient()
            ->getIdentifier());

        if ($this->user) {
            $jwtBuilder->setSubject($this->user
                ->getIdentifier());
            $jwtBuilder->set("subname", $this->user
                ->getName());
        } else {
            $jwtBuilder->setSubject("anonymous");
        }

        $jwtBuilder->set('scopes', $this->getScopes());

        return $jwtBuilder
            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
            ->getToken();
    }
}