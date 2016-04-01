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

    protected $exchange;

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

    /**
     * @param $name string 如果$name为''，只能创建非持久化的队列并且只能绑定到Connection，队列的名称在每次创建的时候随机生成。
     * @return static
     * @throws AMQPQueueException
     */
    public function queue($name) {
        if (is_null($name)) {
            throw new AMQPQueueException('queue cannot be null');
        }
        list($queue_name, ,) = $this->channel->queue_declare(
            $name,
            array_get($this->config, 'queue.passive'),
            $name === '' ? false : array_get($this->config, 'queue.durable'),
            $name === '' ? true : array_get($this->config, 'queue.exclusive'),
            array_get($this->config, 'queue.auto_delete'),
            array_get($this->config, 'queue.no_wait'),
            array_get($this->config, 'queue.arguments'),
            array_get($this->config, 'queue.ticket')
        );
        $this->queue = $queue_name;
        return $this;
    }

    /**
     * @param $exchange string 默认为''，这个是默认的交换器，会绑定所有的队列，并且以队列的名称作为路由。
     * @return static
     * @throws AMQPQueueException
     */
    public function exchange($exchange = '') {
        if (is_null($exchange)) {
            throw new AMQPQueueException('exchange cannot be null');
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

    public function close() {
        $this->channel->close();
        $this->connection->close();
    }

    function __destruct() {
        $this->close();
    }

}