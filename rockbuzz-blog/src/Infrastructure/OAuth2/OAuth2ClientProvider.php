<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:28 PM
 */

namespace RockBuzz\Blog\Infrastructure\OAuth2;

use League\OAuth2\Client\Provider\GenericProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OAuth2ClientProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container[GenericProvider::class] = function(Container $container) {
            $clientId                = $container['settings']['auth']['clientId'];
            $clientSecret            = $container['settings']['auth']['clientSecret'];
            $redirectUri             = $container['settings']['auth']['redirectUri'];
            $urlAuthorize            = $container['settings']['auth']['urlAuthorize'];
            $urlAccessToken          = $container['settings']['auth']['urlAccessToken'];
            $urlResourceOwnerDetails = $container['settings']['auth']['urlResourceOwnerDetails'];

            return new GenericProvider([
                'clientId'                => $clientId,
                'clientSecret'            => $clientSecret,
                'redirectUri'             => $redirectUri,
                'urlAuthorize'            => $urlAuthorize,
                'urlAccessToken'          => $urlAccessToken,
                'urlResourceOwnerDetails' => $urlResourceOwnerDetails,
            ]);
        };
    }
}