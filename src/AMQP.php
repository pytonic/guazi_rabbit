<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午4:17
 */

namespace Gua;


use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMQP {

    /**
     * @var AbstractConnection
     */
    protected $connection;

    protected $config;
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    protected $channel;
    protected $queue;

    public static function with($config) {
        $connection = new AMQPStreamConnection(
            array_get($config, 'connection.host'),
            array_get($config, 'connection.port'),
            array_get($config, 'connection.user'),
            array_get($config, 'connection.password'),
            array_get($config, 'connection.vhost', '/')
        );

        return new static($connection, $config);
    }

    /**
     * Rabbit constructor.
     * @param AbstractConnection $connection
     * @param array $config
     */
    public function __construct(AbstractConnection $connection, $config = []) {
        $this->connection = $connection;
        $this->channel    = $connection->channel();
        $this->config     = $config;
    }

    public function queue($name) {
        $name = $name ?: array_get($this->config, 'queue.name');
        if(is_null($name)){
            throw new \AMQPQueueException('queue cannot be null');
        }
        $this->queue = $name;
        $this->channel->queue_declare(
            $name,
            array_get($this->config, 'queue.passive'),
            array_get($this->config, 'queue.durable'),
            array_get($this->config, 'queue.exclusive'),
            array_get($this->config, 'queue.auto_delete'),
            array_get($this->config, 'queue.no_wait'),
            array_get($this->config, 'queue.arguments'),
            array_get($this->config, 'queue.ticket')
        );
        return $this;
    }


    function __destruct() {
        $this->channel->close();
        $this->connection->close();
    }

}