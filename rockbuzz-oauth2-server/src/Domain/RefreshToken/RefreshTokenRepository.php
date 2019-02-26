<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/16/19
 * Time: 7:36 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\RefreshToken;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Creates a new refresh token.
     *
     * @return RefreshTokenEntity
     */
    public function getNewRefreshToken() {
        return new RefreshTokenEntity();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntity $refreshTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken($refreshTokenEntity) {
        try {
            $this->em->persist($refreshTokenEntity);
            $this->em->flush();
        } catch (ORMException $ex) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId) {
        // TODO: Implement revokeRefreshToken() method.
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId) {
        // TODO: Implement isRefreshTokenRevoked() method.
        return false;
    }
}