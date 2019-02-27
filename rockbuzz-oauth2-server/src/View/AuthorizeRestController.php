<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/17/19
 * Time: 7:32 AM
 */

namespace RockBuzz\OAuth2\Server\View;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizeRestController {

    private $authServer;

    private $logger;

    public function __construct(AuthorizationServer $authServer, Logger $logger) {
        $this->authServer = $authServer;
        $this->logger     = $logger;
    }

    public function token(Request $request, Response $response) {
        try {
            return $this->authServer->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $ex) {
            return $response
                ->withStatus(400, $ex->getMessage())
                ->withJson($ex->getPayload());
        }
    }
}