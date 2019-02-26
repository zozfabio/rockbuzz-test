<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/20/19
 * Time: 7:07 PM
 */

namespace RockBuzz\Blog\Domain;

use GuzzleHttp\Psr7\Request;

interface RequestFactory {

    public function getInstance(string $method, string $uri): Request;
}