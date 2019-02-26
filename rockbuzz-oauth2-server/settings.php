<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 3:23 PM
 */

return [
    'settings' => [
        'displayErrorDetails' => true,
        'doctrine'            => [
            'dev_mode'      => true,
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],
            'connection'    => [
                'url' => 'mysql://root:root@oauth2-server-database:3306/oauth2-server',
            ],
        ],
        'logger'              => [
            'name'  => 'rockbuzz-oauth2-server',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'auth'                => [
            'private_key'            => 'file://' . APP_ROOT . '/private.key',
            'encryption_key'         => APP_ROOT . '/encryptionkey.txt',
            'access_token_duration'  => 'PT1H',
            'refresh_token_duration' => 'P1M',
        ],
    ],
];