<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:15 PM
 */

use RockBuzz\Blog\View\DetailsAction;
use RockBuzz\Blog\View\HomeAction;

$app->get("/", HomeAction::class)
    ->setName("posts.findAll");

$app->get("/{slug}", DetailsAction::class)
    ->setName("posts.findOneBySlug");