<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/21/19
 * Time: 8:45 PM
 */

namespace RockBuzz\Blog\Infrastructure\PhpView;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Views\PhpRenderer;

class PhpViewProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container[PhpRenderer::class] = function(Container $container) {
            $path = $container['settings']['view']['path'];

            return new PhpRenderer($path);
        };
    }
}