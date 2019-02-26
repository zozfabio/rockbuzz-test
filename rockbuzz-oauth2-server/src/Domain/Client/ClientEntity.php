<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 7:03 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\Client;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use RockBuzz\OAuth2\Server\Domain\Scope\ScopeEntity;

/**
 * @Entity
 * @Table(name="client")
 */
class ClientEntity implements ClientEntityInterface {

    /**
     * @var integer
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    public $id;

    /**
     * @var string
     * @Column(type="string", nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $secret;

    /**
     * @var string
     * @Column(name="redirect_uri", type="string")
     */
    private $redirectUri;

    /**
     * @var boolean
     * @Column(type="boolean", nullable=false)
     */
    private $confidential;

    /**
     * @var ArrayCollection | ScopeEntity[]
     * @ManyToMany(targetEntity="RockBuzz\OAuth2\Server\Domain\Scope\ScopeEntity", cascade={"ALL"}, orphanRemoval=true)
     * @JoinTable(name="client_scopes",
     *     joinColumns={@JoinColumn(name="client_id", referencedColumnName="id")},
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
     * @return integer
     */
    public function getIdentifier() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSecret() {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret) {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getRedirectUri() {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri): void {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return boolean
     */
    public function isConfidential() {
        return $this->confidential;
    }

    /**
     * @param boolean $confidential
     */
    public function setConfidential($confidential) {
        $this->confidential = $confidential;
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
}