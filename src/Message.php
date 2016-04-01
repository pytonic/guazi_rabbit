<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午12:42
 */

namespace Gua;


use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class Message
 * @package Gua
 * @property string body
 */
class Message {
    /**
     * 非持久化消息
     */
    const NONE_PERSISTENT = 1;
    /**
     * 持久化消息
     */
    const PERSISTENT = 2;
    /**
     * @var AMQPMessage
     */
    private $original;

    public function __construct($body = '', array $properties = []) {
        $properties     = array_replace([
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ], $properties);
        $this->original = new AMQPMessage($body, $properties);
    }

    public function copy(AMQPMessage $message) {
        $this->original = $message;
    }

    public function __call($method, $args) {
        if (!is_null($this->original)) {
            call_user_func_array([$this->original, $method], $args);
        }
    }

    public function __get($name) {
        return $this->original->$name;
    }

    public function __set($name, $value) {
        $this->original->$name = $value;
    }

    public function ack() {
        $this->original->delivery_info['channel']->basic_ack($this->original->delivery_info['delivery_tag']);
    }

    public function getOriginal() {
        return $this->original;
    }

}