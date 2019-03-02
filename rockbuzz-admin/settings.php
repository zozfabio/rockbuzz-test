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
            'public_key'              => 'file://' . APP_ROOT . '/public.key',
            'clientId'                => 'rockbuzz-admin',
            'clientSecret'            => 'rockbuzzadminsecret',
            'redirectUri'             => 'http://localhost:8003',
            'urlAuthorize'            => 'http://oauth2-server-app:8000/authorize',
            'urlAccessToken'          => 'http://oauth2-server-app:8000/token',
            'urlResourceOwnerDetails' => 'http://post-api-app:8000/api',
            'scope'                   => [
                'authors.findAll',
                'tags.findAll',
                'posts.findAll',
                'posts.findOne',
                'posts.insert',
                'posts.update',
                'posts.delete',
                'posts.published',
                'posts.author',
                'posts.tags',
            ],
        ],
        'client'              => [
            'baseUrl' => 'http://post-api-app:8000/api',
        ],
        'view'                => [
            'path' => APP_ROOT . '/view',
        ],
    ],
];