<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\EndpointClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class EndpointClientTest extends TestCase
{
    use Mockable;

    public function testGetEndpoints()
    {
        $body = [
            'totalCount' => 1,
            'result'     => [
                [
                    'hostname'          => 'endpoint.mqtt.iot.gz.baidubce.com:1884',
                    'mqttHostname'      => 'endpoint.mqtt.iot.gz.baidubce.com:1883',
                    'createTime'        => '2017-10-23T07:00:23Z',
                    'uuid'              => 'd1a2c1c6-42c1-39c2-a7e9-a360346b412b',
                    'accountUuid'       => '28ac42bf05f54ceebe4adf8a84443545',
                    'websocketHostname' => 'endpoint.mqtt.iot.gz.baidubce.com:8884',
                    'mqttTlsHostname'   => 'endpoint.mqtt.iot.gz.baidubce.com:1884',
                    'endpointName'      => 'endpoint',
                ],
            ],
            'order'      => 'desc',
            'orderBy'    => 'createtime',
            'pageSize'   => 50,
            'pageNo'     => 1,
        ];

        $endpoint_client = $this->getEndpointClient(compact('body'));

        parent::assertArraySubset($body, $endpoint_client->getEndpoints());
    }

    public function testGetEndpoint()
    {
        $body = [
            'hostname'          => 'endpoint.mqtt.iot.gz.baidubce.com:1884',
            'mqttHostname'      => 'endpoint.mqtt.iot.gz.baidubce.com:1883',
            'createTime'        => '2017-10-23T07:00:23Z',
            'uuid'              => 'd1a2c1c6-42c1-39c2-a7e9-a360346b412b',
            'accountUuid'       => '28ac42bf05f54ceebe4adf8a84443545',
            'websocketHostname' => 'endpoint.mqtt.iot.gz.baidubce.com:8884',
            'mqttTlsHostname'   => 'endpoint.mqtt.iot.gz.baidubce.com:1884',
            'endpointName'      => 'endpoint',
        ];

        $endpoint_client = $this->getEndpointClient(compact('body'));

        parent::assertArraySubset($body, $endpoint_client->getEndpoint('endpoint'));
    }

    public function testSetEndpoint()
    {
        $body = [
            'mqttHostname'      => 'endpoint.mqtt.iot.gz.baidubce.com:1883',
            'accountUuid'       => '28ac42bf05f54ceebe4adf8a84443545',
            'hostname'          => 'endpoint.mqtt.iot.gz.baidubce.com:1884',
            'endpointName'      => 'endpoint',
            'mqttTlsHostname'   => 'endpoint.mqtt.iot.gz.baidubce.com:1884',
            'createTime'        => '2017-10-23T07:00:23Z',
            'websocketHostname' => 'endpoint.mqtt.iot.gz.baidubce.com:8884',
            'uuid'              => '3dd66250-38b9-4981-9036-a69f52a16e0c',
        ];

        $endpoint_client = $this->getEndpointClient(['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $endpoint_client->setEndpoint('endpoint'));
    }

    public function testUnsetEndpoint()
    {
        $endpoint_client = $this->getEndpointClient(['status' => 204]);

        parent::assertNull($endpoint_client->unsetEndpoint('endpoint'));
    }

    private function getEndpointClient($response_options = [])
    {
        $status = $response_options['status'] ?? 200;

        if (isset($response_options['body'])) {
            $body = json_encode($response_options['body']);
        } else {
            $body = null;
        }

        return new EndpointClient(
            $this->getMockSigner(),
            $this->getMockHttpClient($status, $body)
        );
    }
}
