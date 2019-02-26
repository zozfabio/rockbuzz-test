<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:20 PM
 */

namespace RockBuzz\Post\Infrastructure\Doctrine;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DoctrineORMProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container) {
        $container[DoctrineSQLLogger::class] = function(Container $container) {
            $logger = $container[Logger::class];

            return new DoctrineSQLLogger($logger);
        };

        $container[EntityManager::class] = function(Container $container) {
            $logger = $container[DoctrineSQLLogger::class];

            $connection   = $container['settings']['doctrine']['connection'];
            $metadataDirs = $container['settings']['doctrine']['metadata_dirs'];
            $devMode      = $container['settings']['doctrine']['dev_mode'];

            $config = Setup::createAnnotationMetadataConfiguration($metadataDirs, $devMode);

            $config->setSQLLogger($logger);
            $config->setMetadataDriverImpl(new AnnotationDriver(new AnnotationReader(), $metadataDirs));

            return EntityManager::create($connection, $config);
        };
    }

}