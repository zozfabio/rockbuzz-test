<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/20/19
 * Time: 7:49 PM
 */

namespace RockBuzz\Admin\Infrastructure\Guzzle;

use Pimple\Container;
use RockBuzz\Admin\Domain\RequestFactory;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestFactoryRegisterMiddleware {

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next): Response {
        $this->container[RequestFactory::class] = function(Container $container) use ($request) {
            return new RequestFactoryImpl($request, $container);
        };

        /** @var Response $response */
        $response = $next($request, $response);

        return $response;
    }
}