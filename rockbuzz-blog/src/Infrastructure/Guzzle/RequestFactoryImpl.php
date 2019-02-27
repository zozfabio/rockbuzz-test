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

    /** @var Logger */
    private $logger;

    /** @var GenericProvider */
    private $tokenProvider;

    /** @var array */
    private $tokenScopes;

    /** @var string */
    private $tokenStorePath;

    public function __construct(Container $container) {
        $this->logger         = $container[Logger::class];
        $this->tokenProvider  = $container[GenericProvider::class];
        $this->tokenScopes    = $container['settings']['auth']['scope'];
        $this->tokenStorePath = $container['settings']['auth']['accessTokenStorePath'];
    }

    private function getStoredToken(): string {
        $dirName = dirname($this->tokenStorePath);
        if (!is_dir($dirName)) {
            mkdir($dirName, 0777, true);
        }
        if (file_exists($this->tokenStorePath)) {
            return file_get_contents($this->tokenStorePath);
        }
        return "";
    }

    private function issueNewToken(): string {
        try {
            $newToken = $this->tokenProvider->getAccessToken("client_credentials", [
                "scope" => $this->tokenScopes,
            ]);

            file_put_contents($this->tokenStorePath, $newToken->getToken());

            return $newToken->getToken();
        } catch (IdentityProviderException $ex) {
            throw new RepositoryException("Failed to issue a new token on oauth2 service.", 0, $ex);
        }
    }

    private function getStoredOrIssueNewToken() {
        $storedToken = $this->getStoredToken();
        if ($storedToken) {
            $accessToken = (new Parser())->parse($storedToken);
            $now         = (new \DateTime("now"))->getTimestamp();
            $expiration  = $accessToken->getClaim("exp");

            if (($expiration - $now) > 60) {
                return $storedToken;
            }
        }
        return $this->issueNewToken();
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