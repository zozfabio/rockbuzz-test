<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/16/19
 * Time: 7:32 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\AccessToken;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Monolog\Logger;
use RockBuzz\OAuth2\Server\Domain\Client\ClientEntity;
use RockBuzz\OAuth2\Server\Domain\Scope\ScopeEntity;
use RockBuzz\OAuth2\Server\Domain\User\UserRepository;

class AccessTokenRepository implements AccessTokenRepositoryInterface {

    private $em;

    private $logger;

    private $users;

    public function __construct(EntityManager $em, Logger $logger, UserRepository $users) {
        $this->em     = $em;
        $this->logger = $logger;
        $this->users  = $users;
    }

    /**
     * Create a new access token.
     *
     * @param ClientEntity $clientEntity
     * @param ScopeEntity[] $scopes
     * @param string $userIdentifier
     *
     * @return AccessTokenEntity
     */
    public function getNewToken($clientEntity, $scopes, $userIdentifier = null) {
        $accessToken = new AccessTokenEntity();

        if ($userIdentifier) {
            $user = $this->users->findOneByEmail($userIdentifier);
            $accessToken->setUser($user);
        }

        return $accessToken;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntity $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken($accessTokenEntity) {
        try {
            $this->em->persist($accessTokenEntity);
            $this->em->flush();
        } catch (ORMException $ex) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId) {
        // TODO: Implement revokeAccessToken() method.
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId) {
        // TODO: Implement isAccessTokenRevoked() method.
        return false;
    }
}