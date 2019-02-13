<?php

return [

   'default' => 'postgres',

   'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
         ],

        'postgres' => [
            'driver'    => 'pgsql',
            'host'      => env('DB_HOST','localhost'),
            'port'      => env('DB_PORT','5432'),
            'database'  => env('DB_DATABASE','blog'),
            'username'  => env('DB_USERNAME','root'),
            'password'  => env('DB_PASSWORD','123456'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false
        ],
    ],
];