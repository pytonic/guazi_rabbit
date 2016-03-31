<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 上午11:44
 */

return [
    'connection' => [
        'host' => '127.0.0.1',
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
    ],

    'exchange' => [
        'name' => '',
        'type' => 'fanout',
        'passive' => false,
        'durable' => true,
        'auto_delete' => false,
        'internal' => false,
        'nowait' => false,
        'arguments' => null,
        'ticket' => null,
    ],
    'queue' => [
        'name' => 'default',
        'passive' => false,
        'durable' => true,
        'exclusive' => false,
        'auto_delete' => false,
        'no_wait' => false,
        'arguments' => null,
        'ticket' => null,
    ]
];