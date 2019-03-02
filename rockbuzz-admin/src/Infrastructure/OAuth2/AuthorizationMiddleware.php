<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/27/19
 * Time: 4:42 PM
 */

namespace RockBuzz\Admin\Infrastructure\OAuth2;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class AuthorizationMiddleware {

    private $publicKey;

    private $router;

    public function __construct(string $publicKey, Router $router) {
        $this->publicKey = $publicKey;
        $this->router    = $router;
    }

    public function __invoke(Request $request, Response $response, callable $next) {
        $cookieToken = $request->getCookieParam('admin_access_token');
        if (!$cookieToken) {
            return $response->withRedirect($this->router->pathFor("login.get"));
        }

        $token = (new Parser())->parse($cookieToken);
        if ($token->verify(new Sha256(), $this->publicKey) === false) {
            return $response->withRedirect($this->router->pathFor("login.get"));
        }

        $data = new ValidationData();
        $data->setCurrentTime(time());
        if ($token->validate($data) === false) {
            // TODO: issue new access token from refresh token, instead of redirect to login
            return $response->withRedirect($this->router->pathFor("login.get"));
        }

        $request = $request
            ->withAttribute("oauth_access_token_id", $token->getClaim("jti"))
            ->withAttribute("oauth_client_id", $token->getClaim("aud"))
            ->withAttribute("oauth_user_id", $token->getClaim("sub"))
            ->withAttribute("oauth_scopes", $token->getClaim("scopes"));

        return $next($request, $response);
    }
}