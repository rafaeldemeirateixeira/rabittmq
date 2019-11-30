# RabittMQ producer and consumer
## Docker
Run container:
```
$ docker run -d --hostname my-rabbit --name some-rabbit -p 8080:15672 -p 5672:5672 rabbitmq:management-alpine
```

## Project
* Start to your project `composer install`.
* Open terminal and run producer: `php -f producer.php`;
* In other teminal run yours consumers: `php -f consumer.php`

