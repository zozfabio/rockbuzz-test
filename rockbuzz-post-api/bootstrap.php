<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:16 PM
 */

use RockBuzz\Post\Infrastructure\App\AppProvider;
use RockBuzz\Post\Infrastructure\Doctrine\DoctrineORMProvider;
use RockBuzz\Post\Infrastructure\Monolog\MonologProvider;
use RockBuzz\Post\Infrastructure\OAuth2\ResourceServerProvider;
use Slim\Container;

require_once __DIR__ . '/vendor/autoload.php';

define('APP_ROOT', __DIR__);

$container = new Container(require __DIR__ . '/settings.php');

$container->register(new DoctrineORMProvider())
    ->register(new MonologProvider())
    ->register(new ResourceServerProvider())
    ->register(new AppProvider());

return $container;