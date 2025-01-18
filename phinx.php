<?php

return [
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'name' => env('DB_NAME'),
            'user' => env('DB_USER'),
            'pass' =>  env('DB_PASSWORD'),
            'port' => env('DB_PORT'),
            'charset' => env('DB_CHARSET'),
        ],
    ],
];
