<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:32 PM
 */

namespace RockBuzz\Post\Infrastructure\OAuth2;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface {

    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null) {
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity) {
    }

    public function revokeAccessToken($tokenId) {
    }

    public function isAccessTokenRevoked($tokenId) {
        return false;
    }
}