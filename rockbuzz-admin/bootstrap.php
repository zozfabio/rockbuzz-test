<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:15 PM
 */

use RockBuzz\Admin\Infrastructure\App\AppProvider;
use RockBuzz\Admin\Infrastructure\Guzzle\GuzzleProvider;
use RockBuzz\Admin\Infrastructure\Monolog\MonologProvider;
use RockBuzz\Admin\Infrastructure\OAuth2\OAuth2ClientProvider;
use RockBuzz\Admin\Infrastructure\PhpView\PhpViewProvider;
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