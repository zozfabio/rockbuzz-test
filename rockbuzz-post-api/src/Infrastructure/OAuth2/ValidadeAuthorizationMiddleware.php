<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 7:58 PM
 */

namespace RockBuzz\Post\Infrastructure\OAuth2;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class ValidadeAuthorizationMiddleware {

    public function __invoke(Request $request, Response $response, callable $next) {
        /** @var Route $route */
        $route = $request->getAttribute("route");
        /** @var array $scopes */
        $scopes = $request->getAttribute("oauth_scopes");

        if (array_search($route->getName(), $scopes) === false) {
            return $response->withStatus(403, "Token don't give access to this resource.");
        }

        return $next($request, $response);
    }
}