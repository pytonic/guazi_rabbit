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

*注意*  
* 队列的名称为空时，将创建一个带有随机名称，绑定到当前连接且非持久化的队列。这个队列将在连接关闭后自动删除。
* 默认的交换器的类型是direct，需要在发送时指定路由键
* 消息必须在代码中显示确认，才会在队列中移除这条消息