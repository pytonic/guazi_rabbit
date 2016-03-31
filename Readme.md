##RabbitMQ 的客户端
用法
1.向分发器发送消息

    $publisher = Publisher::with($config);
    $data = [
        'message'=>'hello world'
    ];
    $message = new \Gua\Message(json_encode($data));
    $publisher->exchange(self::EXCHANGE)->publish($message,'consoles');
