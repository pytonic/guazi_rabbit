<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午2:55
 */

namespace Gua;


use PhpAmqpLib\Message\AMQPMessage;

class Consumer extends AMQP {

    public function consume($exchange, $topics = null, callable $back = null) {
        if (!empty($exchange)) {
            $this->exchange($exchange);
        }
        if (empty($topics) && !empty($exchange)) {
            foreach ($topics as $binding_key) {
                $this->channel->queue_bind($this->queue, $exchange, $binding_key);
            }
        } elseif (!empty($exchange)) {
            $this->channel->queue_bind($this->queue, $exchange);
        }
        $this->channel->basic_qos(null, 1, null);
        $callback = function (AMQPMessage $message) use ($back) {
            try {
                $back($message->getBody(), $message);
                $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
            } catch (\Exception $e) {
                $this->close();
                throw $e;
            }
        };
        $this->channel->basic_consume($this->queue, '', false, false, false, false, $callback);
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

    }

}