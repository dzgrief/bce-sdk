<?php

namespace Dzgrief\Bce\Services\IotHub;

use Dzgrief\Bce\HttpContentTypes;
use Dzgrief\Bce\SimpleHttpClient;
use GuzzleHttp\ClientInterface;

class MqttClient extends SimpleHttpClient
{
    const SERVICE_HOST = 'api.mqtt.iot.gz.baidubce.com';

    protected $username;
    protected $password;

    public function __construct($username, $password, ClientInterface $http_client = null)
    {
        parent::__construct($http_client);

        $this->username = $username;
        $this->password = $password;
    }

    /**
     * 发布消息
     *
     * @param  string  $message
     * @param  integer $qos
     * @param  string  $topic
     * @param  boolean $retain
     * @return void
     */
    public function publishMessage($message, $qos, $topic, $retain = false)
    {
        $options = [
            'headers' => [
                'content-type' => HttpContentTypes::OCTET_STREAM,
                'auth.username' => $this->username,
                'auth.password' => $this->password,
            ],
            'query'   => compact('qos', 'topic', 'retain'),
            'body'    => $message,
        ];

        parent::request('POST', self::SERVICE_HOST, '/v1/proxy', $options);
    }
}
