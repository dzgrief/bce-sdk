<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\HttpContentTypes;
use Dzgrief\Bce\Services\IotHub\MqttClient;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class MqttClientTest extends TestCase
{
    public function testPublishMessage()
    {
        $mqtt_client = $this->getMqttClient();

        parent::assertNull($mqtt_client->publishMessage('message', 1, 'topic'));
    }

    private function getMqttClient()
    {
        $headers = ['content-type' => HttpContentTypes::OCTET_STREAM];
        $response = new Response(201, $headers);

        $mock_http_client = parent::createMock(HttpClient::class);
        $mock_http_client->method('request')->willReturn($response);

        $mqtt_client = new MqttClient('endpoint/thing', 'bw3qWSy2l1QgiePN3b7beWOVaGoObiR9ZefT70cKnBB=');
        $mqtt_client->setHttpClient($mock_http_client);

        return $mqtt_client;
    }
}
