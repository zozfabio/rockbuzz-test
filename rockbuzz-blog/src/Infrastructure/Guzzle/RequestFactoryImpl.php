<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/20/19
 * Time: 5:11 PM
 */

namespace RockBuzz\Blog\Infrastructure\Guzzle;

use Lcobucci\JWT\Parser;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Blog\Domain\RepositoryException;
use RockBuzz\Blog\Domain\RequestFactory;

class RequestFactoryImpl implements RequestFactory {

    private $setCookie = null;

    private $request;

    /** @var GenericProvider */
    private $tokenProvider;

    /** @var array */
    private $tokenScopes;

    /** @var Logger */
    private $logger;

    public function __construct(\Slim\Http\Request $request, Container $container) {
        $this->request = $request;

        $this->tokenProvider = $container[GenericProvider::class];
        $this->tokenScopes   = $container['settings']['auth']['scope'];

        $this->logger = $container[Logger::class];
    }

    public function getSetCookie(): ?string {
        return $this->setCookie;
    }

    private function getStoredOrIssueNewToken() {
        $cookieToken = $this->request->getCookieParam("blog_token");
        if ($cookieToken) {
            $this->logger->debug("Stored token: ", [$cookieToken]);
            $token      = (new Parser())->parse($cookieToken);
            $now        = (new \DateTime("now"))->getTimestamp();
            $expiration = $token->getClaim("exp");

            if (($expiration - $now) > 30) {
                $this->logger->debug("Stored token still valid. " . ($expiration - $now) . " seconds remaining until it's expires.");
                return $cookieToken;
            }
        }
        try {
            $this->logger->debug("Let's issue a new token");
            $newToken = $this->tokenProvider->getAccessToken("client_credentials", [
                "scope" => $this->tokenScopes,
            ]);

            $requestUri  = $this->request->getUri();
            $requestHost = $requestUri->getHost();

            $this->setCookie = "blog_token={$newToken->getToken()}; Domain={$requestHost}; Max-Age=3600; HttpOnly";

            $this->logger->debug("New token: ", [$newToken->getToken()]);

            return $newToken->getToken();
        } catch (IdentityProviderException $ex) {
            throw new RepositoryException("Failed to issue a new token on oauth2 service.", 0, $ex);
        }
    }

    public function getInstance(string $method, string $uri): \GuzzleHttp\Psr7\Request {
        $headers = [
            "Accept"        => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "Bearer {$this->getStoredOrIssueNewToken()}",
        ];

        return new \GuzzleHttp\Psr7\Request($method, $uri, $headers);
    }
}