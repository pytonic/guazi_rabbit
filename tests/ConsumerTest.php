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
        define('AMQP_DEBUG',true);
    }

    public function testConsumerWithException() {
        try{

            $this->consumer->queue('contract_payments')->consume('payments',['payment_ok'],function(\Gua\Message $message){
                echo $message->body;
                $message->ack();
                throw  new Exception('1');
            });
        }catch(Exception $e){
            $this->assertTrue(true);
        }

    }
}