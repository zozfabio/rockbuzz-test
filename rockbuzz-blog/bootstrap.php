<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:15 PM
 */

use RockBuzz\Blog\Infrastructure\App\AppProvider;
use RockBuzz\Blog\Infrastructure\Guzzle\GuzzleProvider;
use RockBuzz\Blog\Infrastructure\Monolog\MonologProvider;
use RockBuzz\Blog\Infrastructure\OAuth2\OAuth2ClientProvider;
use RockBuzz\Blog\Infrastructure\PhpView\PhpViewProvider;
use Slim\Container;

require_once __DIR__ . '/vendor/autoload.php';

define('APP_ROOT', __DIR__);

$container = new Container(require __DIR__ . '/settings.php');

$container->register(new MonologProvider())
    ->register(new OAuth2ClientProvider())
    ->register(new GuzzleProvider())
    ->register(new PhpViewProvider())
    ->register(new AppProvider());

return $container;