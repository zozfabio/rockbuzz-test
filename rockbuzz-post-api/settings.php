<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/18/19
 * Time: 8:16 PM
 */

return [
    'settings' => [
        'displayErrorDetails' => true,
        'doctrine'            => [
            'dev_mode'      => true,
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],
            'connection'    => [
                'url' => 'mysql://root:root@post-api-database:3306/post-api',
            ],
        ],
        'logger'              => [
            'name'  => 'post-api',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'auth'                => [
            'public_key' => 'file://' . APP_ROOT . '/public.key',
        ],
    ],
];