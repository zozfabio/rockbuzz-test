<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/19/19
 * Time: 7:14 PM
 */

return [
    'settings' => [
        'displayErrorDetails' => true,
        'logger'              => [
            'name'  => 'blog',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'auth'                => [
            'clientId'                => 'rockbuzz-blog',
            'clientSecret'            => 'rockbuzzblogsecret',
            'redirectUri'             => 'http://localhost:8002',
            'urlAuthorize'            => 'http://oauth2-server-app:8000/authorize',
            'urlAccessToken'          => 'http://oauth2-server-app:8000/token',
            'urlResourceOwnerDetails' => 'http://post-api-app:8000/api',
            'scope'                   => [
                'authors.findAll',
                'tags.findAll',
                'posts.findAll',
                'posts.findOneBySlug',
                'posts.author',
                'posts.tags',
            ],
            'accessTokenStorePath'    => APP_ROOT . '/var/guzzle/accesstoken.txt',
        ],
        'client'              => [
            'baseUrl' => 'http://post-api-app:8000/api',
        ],
        'view'                => [
            'path' => APP_ROOT . '/view',
        ],
    ],
];