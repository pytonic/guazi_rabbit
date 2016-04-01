<?php
use Gua\Publisher;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-29
 * Time: 下午8:17
 */

class PublisherTest extends TestCase {

    private $config;

    const EXCHANGE = 'payments';

    public function setUp() {
        $this->config = include dirname(__DIR__) . '/config/rabbit.php';
        define('AMQP_DEBUG',true);
    }

    public function testCreatePublisher() {
        $t0 = microtime(true);
        $publisher = Publisher::with($this->config);
        $t1 = microtime(true);
        $data = [
            'message'=>'hello world'
        ];
        $message = new \Gua\Message(json_encode($data));
        $publisher->exchange(self::EXCHANGE)->publish($message,'payment_ok');
        echo $t1-$t0.PHP_EOL;
        echo microtime(true)-$t1.PHP_EOL;

    }

}