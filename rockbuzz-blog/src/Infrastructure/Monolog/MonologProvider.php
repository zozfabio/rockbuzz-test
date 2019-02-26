<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:26 PM
 */

namespace RockBuzz\Blog\Infrastructure\Monolog;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MonologProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container[Logger::class] = function($container) {
            $name  = $container['settings']['logger']['name'];
            $level = $container['settings']['logger']['level'];

            $logger = new Logger($name);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler("php://stdout", $level));

            return $logger;
        };
    }
}