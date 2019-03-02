<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/20/19
 * Time: 5:11 PM
 */

namespace RockBuzz\Admin\Infrastructure\Guzzle;

use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Admin\Domain\RequestFactory;

class RequestFactoryImpl implements RequestFactory {

    private $request;

    /** @var Logger */
    private $logger;

    public function __construct(\Slim\Http\Request $request, Container $container) {
        $this->request = $request;

        $this->logger = $container[Logger::class];
    }

    public function getInstance(string $method, string $uri): \GuzzleHttp\Psr7\Request {
        $headers = [
            "Accept"        => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "Bearer {$this->request->getCookieParam("admin_access_token")}",
        ];

        return new \GuzzleHttp\Psr7\Request($method, $uri, $headers);
    }
}