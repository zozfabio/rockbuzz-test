<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 3:42 PM
 */

use RockBuzz\OAuth2\Server\View\AuthorizeRestController;

$app->post('/token', AuthorizeRestController::class . ':token');