<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:25 PM
 */

namespace RockBuzz\Post\Infrastructure\App;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

class AppProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container["errorHandler"] = function(Container $container) {
            return new ErrorHandler();
        };

        $container[ParamToEntityConverterMiddlewareFactory::class] = function(Container $container) {
            return new ParamToEntityConverterMiddlewareFactory($container);
        };

        $container[App::class] = function(Container $container) {
            $app = new App($container);

            require_once APP_ROOT . '/dependencies.php';
            require_once APP_ROOT . '/routes.php';

            return $app;
        };
    }
}