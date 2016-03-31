RabbitMQ 的客户端
---
安装
----
1.composer
```
{
    ……
    "repositories": [
        {
            "type": "git",
            "url": "git@git.guazi-corp.com:zhaixiaolei/rabbit.git"
        }
    ],
    "require": {
        "videlalvaro/php-amqplib": "2.2.*",
        "guazi/rabbit": "dev-master"
    }
    ……
}
```
用法
----
1.向分发器发送消息

    $publisher = Publisher::with($config);
    $data = [
        'message'=>'hello world'
    ];
    $message = new \Gua\Message(json_encode($data));
    $publisher->exchange(self::EXCHANGE)->publish($message,'consoles');
2.接收消息

        $consumer = \Gua\Consumer::with($config);
        $consumer->queue('console')->consume('payments',function($message){
            echo $message;
        });

