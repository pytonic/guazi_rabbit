<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午3:32
 */
class ConsumerTest extends TestCase{

    private $config;
    /**
     * @var \Gua\Consumer
     */
    private $client;

    public function setUp() {
        $this->config = include dirname(__DIR__).'/config/rabbit.php';
        $config = $this->config;
        $class        = $this->getMockClass(\Gua\Consumer::class);
        $connection = new AMQPStreamConnection(
            array_get($config, 'connection.host'),
            array_get($config, 'connection.port'),
            array_get($config, 'connection.user'),
            array_get($config, 'connection.password'),
            array_get($config, 'connection.vhost', '/')
        );
        $this->client = new $class($connection,$this->config);
    }

    public function testClient() {
        $this->client->queue('console')->consume('payments',function($message){
            echo $message;
        });
    }
}