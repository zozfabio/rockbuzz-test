<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:29 PM
 */

namespace RockBuzz\Post\Infrastructure\OAuth2;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ResourceServerProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container[AccessTokenRepository::class] = function() {
            return new AccessTokenRepository();
        };

        $container[AuthorizationServer::class] = function(Container $container) {
            $accessTokens = $container[AccessTokenRepository::class];

            $publicKey = $container['settings']['auth']['public_key'];

            return new ResourceServer($accessTokens, $publicKey);
        };

        $container[ResourceServerMiddleware::class] = function(Container $container) {
            $server = $container[AuthorizationServer::class];

            return new ResourceServerMiddleware($server);
        };

        $container[ValidadeAuthorizationMiddleware::class] = function() {
            return new ValidadeAuthorizationMiddleware();
        };
    }
}