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

    public function setUp() {
        $this->config = include dirname(__DIR__).'/config/rabbit.php';
    }

    public function testClient() {
        $consumer = \Gua\Consumer::with($this->config);
        $consumer->queue('console')->consume('payments',function($message){
            echo $message;
        });
    }
}