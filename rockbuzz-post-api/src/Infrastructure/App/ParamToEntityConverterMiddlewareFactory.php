<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/27/19
 * Time: 10:03 PM
 */

namespace RockBuzz\Post\Infrastructure\App;

use Pimple\Container;
use RockBuzz\Post\Domain\Repository;

class ParamToEntityConverterMiddlewareFactory {

    /** @var Container */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function getInstance(string $param, string $repositoryClass) {
        /** @var Repository $repository */
        $repository = $this->container[$repositoryClass];

        return new ParamToEntityConverterMiddleware($param, $repository);
    }
}