<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 9:20 PM
 */

namespace RockBuzz\Blog\Infrastructure\Guzzle;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use RockBuzz\Blog\Domain\RequestFactory;

class GuzzleProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container[RequestFactory::class] = function(Container $container) {
            return new RequestFactoryImpl($container);
        };

        $container[Client::class] = function(Container $container) {
            $baseUrl = $container['settings']['client']['baseUrl'];

            return new Client([
                "base_uri" => $baseUrl
            ]);
        };
    }
}