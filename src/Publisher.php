<?php
namespace Gua;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 上午11:19
 */
class Publisher extends AMQP{

    public function publish(Message $message, $routingKey = '') {
        $this->channel->basic_publish($message, $this->exchange, $routingKey);
    }

}