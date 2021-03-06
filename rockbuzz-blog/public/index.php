<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:15 PM
 */

use Slim\App;
use Slim\Container;

/** @var Container $container */
$container = require_once __DIR__ . '/../bootstrap.php';

/** @var App $app */
$app = $container[App::class];

$app->run();