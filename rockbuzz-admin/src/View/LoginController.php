<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 8:10 AM
 */

namespace RockBuzz\Admin\View;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Pimple\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class LoginController {

    /** @var Router */
    private $router;

    /** @var PhpRenderer */
    private $views;

    /** @var GenericProvider */
    private $tokenProvider;

    /** @var string[] */
    private $scopes;

    public function __construct(Container $container) {
        $this->router        = $container["router"];
        $this->views         = $container[PhpRenderer::class];
        $this->tokenProvider = $container[GenericProvider::class];
        $this->scopes        = $container["settings"]["auth"]["scope"];
    }

    public function login(Request $request, Response $response) {
        return $this->views->render($response, "/login.php", [
            "router"   => $this->router,
            "error"    => "",
            "username" => "",
        ]);
    }

    public function doLogin(Request $request, Response $response) {
        $username = $request->getParam("username");
        $password = $request->getParam("password");

        try {
            $newToken = $this->tokenProvider->getAccessToken("password", [
                "scope"    => $this->scopes,
                "username" => $username,
                "password" => $password,
            ]);

            $requestUri  = $request->getUri();
            $requestHost = $requestUri->getHost();
            $cookie      = "admin_access_token={$newToken->getToken()}; Domain={$requestHost}; Max-Age=3600; HttpOnly";

            return $response
                ->withAddedHeader("Set-Cookie", $cookie)
                ->withRedirect($this->router->pathFor("posts.findAll"));
        } catch (IdentityProviderException $ex) {
            return $this->views->render($response, "/login.php", [
                "router"   => $this->router,
                "error"    => $ex->getResponseBody()["message"],
                "username" => $username,
            ]);
        }
    }

    public function doLogout(Request $request, Response $response) {
        $requestUri  = $request->getUri();
        $requestHost = $requestUri->getHost();
        $cookie      = "admin_access_token=; Domain={$requestHost}; Max-Age=0; HttpOnly";

        return $response->withAddedHeader("Set-Cookie", $cookie)
            ->withRedirect($this->router->pathFor("posts.findAll"));
    }
}