<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 3:46 PM
 */

use Defuse\Crypto\Key;
use Doctrine\ORM\EntityManager;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use Monolog\Logger;
use Pimple\Container;
use RockBuzz\OAuth2\Server\Domain\AccessToken\AccessTokenRepository;
use RockBuzz\OAuth2\Server\Domain\Client\ClientRepository;
use RockBuzz\OAuth2\Server\Domain\RefreshToken\RefreshTokenRepository;
use RockBuzz\OAuth2\Server\Domain\Scope\ScopeRepository;
use RockBuzz\OAuth2\Server\Domain\User\UserRepository;
use RockBuzz\OAuth2\Server\View\AuthorizeRestController;

$container = $app->getContainer();

$container[UserRepository::class] = function(Container $container) {
    $em = $container[EntityManager::class];

    return new UserRepository($em);
};

$container[ScopeRepository::class] = function(Container $container) {
    $em = $container[EntityManager::class];

    return new ScopeRepository($em);
};

$container[ClientRepository::class] = function(Container $container) {
    $em = $container[EntityManager::class];

    return new ClientRepository($em);
};

$container[AccessTokenRepository::class] = function(Container $container) {
    $em     = $container[EntityManager::class];
    $logger = $container[Logger::class];
    $users  = $container[UserRepository::class];

    return new AccessTokenRepository($em, $logger, $users);
};

$container[RefreshTokenRepository::class] = function(Container $container) {
    $em = $container[EntityManager::class];

    return new RefreshTokenRepository($em);
};

$container[PasswordGrant::class] = function(Container $container) {
    $users         = $container[UserRepository::class];
    $refreshTokens = $container[RefreshTokenRepository::class];

    $refreshTokenDuration = $container['settings']['auth']['refresh_token_duration'];

    $passwordGrant = new PasswordGrant($users, $refreshTokens);
    $passwordGrant->setRefreshTokenTTL(new DateInterval($refreshTokenDuration));

    return $passwordGrant;
};

$container[ClientCredentialsGrant::class] = function() {
    return new ClientCredentialsGrant();
};

$container[AuthorizationServer::class] = function(Container $container) {
    $scopes                 = $container[ScopeRepository::class];
    $clients                = $container[ClientRepository::class];
    $accessTokens           = $container[AccessTokenRepository::class];
    $passwordGrant          = $container[PasswordGrant::class];
    $clientCredentialsGrant = $container[ClientCredentialsGrant::class];

    $privateKey          = $container['settings']['auth']['private_key'];
    $encryptionKey       = $container['settings']['auth']['encryption_key'];
    $accessTokenDuration = $container['settings']['auth']['access_token_duration'];

    $encryptionKey = Key::loadFromAsciiSafeString(file_get_contents($encryptionKey));

    $server = new AuthorizationServer($clients, $accessTokens, $scopes, $privateKey, $encryptionKey);
    $server->enableGrantType($passwordGrant, new DateInterval($accessTokenDuration));
    $server->enableGrantType($clientCredentialsGrant, new DateInterval($accessTokenDuration));

    return $server;
};

$container[AuthorizeRestController::class] = function(Container $container) {
    $authServer = $container[AuthorizationServer::class];
    $logger     = $container[Logger::class];

    return new AuthorizeRestController($authServer, $logger);
};