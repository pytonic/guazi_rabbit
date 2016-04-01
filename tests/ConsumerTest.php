<?php

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午3:32
 */
class ConsumerTest extends TestCase{

    /**
     * @var \Gua\Consumer
     */
    private $consumer;
    private $config;

    public function setUp() {
        $this->config = include dirname(__DIR__).'/config/rabbit.php';
        $this->consumer = \Gua\Consumer::with($this->config);
    }

//    public function testClient() {
//        $this->consumer->queue('console')->consume('payments',function($message,\PhpAmqpLib\Message\AMQPMessage $amqpMessage){
//            echo $message;
//        });
//    }

    public function testConsumerWithException() {
        try{

            $this->consumer->queue('')->consume('payments',function($message){
                echo $message;
                throw  new Exception('1');
            });
        }catch(Exception $e){
            $this->assertTrue(true);
        }

    }
}