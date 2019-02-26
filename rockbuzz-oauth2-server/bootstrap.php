<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 3:24 PM
 */

use RockBuzz\OAuth2\Server\Infrastructure\App\AppProvider;
use RockBuzz\OAuth2\Server\Infrastructure\Doctrine\DoctrineORMProvider;
use RockBuzz\OAuth2\Server\Infrastructure\Monolog\MonologProvider;
use Slim\Container;

require_once __DIR__ . '/vendor/autoload.php';

define('APP_ROOT', __DIR__);

$container = new Container(require __DIR__ . '/settings.php');

$container->register(new DoctrineORMProvider())
    ->register(new MonologProvider())
    ->register(new AppProvider());

return $container;