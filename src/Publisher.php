<?php
namespace Gua;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 上午11:19
 */
class Publisher extends AMQP{

    private $exchange;

    /**
     * @param $exchange
     * @return Publisher
     * @throws \AMQPQueueException
     */
    public function exchange($exchange = null) {
        $exchange       = $exchange ?: array_get($this->config, 'exchange.name');
        if(is_null($exchange)){
            throw new \AMQPQueueException('exchange cannot be null');
        }
        $this->exchange = $exchange;
        $this->channel->exchange_declare(
            $exchange,
            array_get($this->config, 'exchange.type'),
            array_get($this->config, 'exchange.passive'),
            array_get($this->config, 'exchange.durable'),
            array_get($this->config, 'exchange.auto_delete'),
            array_get($this->config, 'exchange.internal'),
            array_get($this->config, 'exchange.nowait'),
            array_get($this->config, 'exchange.arguments'),
            array_get($this->config, 'exchange.ticket')
        );
        return $this;
    }

    public function publish(Message $message, $routingKey = '') {
        $this->channel->basic_publish($message, $this->exchange, $routingKey);
    }

}