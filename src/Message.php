<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午12:42
 */

namespace Gua;


use PhpAmqpLib\Message\AMQPMessage;

class Message extends AMQPMessage{
    /**
     * 非持久化消息
     */
    const NONE_PERSISTENT = 1;
    /**
     * 持久化消息
     */
    const PERSISTENT = 2;

    public function __construct($body, array $properties=[]) {
        $properties = array_replace([
            'delivery_mode' => self::PERSISTENT,
        ], $properties);
        parent::__construct($body, $properties);
    }


}