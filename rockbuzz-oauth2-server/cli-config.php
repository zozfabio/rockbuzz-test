<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 4:28 PM
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;

/** @var Container $container */
$container = require_once __DIR__ . '/bootstrap.php';

ConsoleRunner::run(
    ConsoleRunner::createHelperSet($container[EntityManager::class])
);