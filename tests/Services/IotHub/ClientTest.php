<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\Client;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    use Mockable;

    public function testIsOnline()
    {
        $body = false;
        $thing_client = $this->getClient(compact('body'));

        parent::assertSame($body, $thing_client->isOnline('endpoint', 'mqttid1'));
    }

    public function testIsOnlines()
    {
        $body = [
            [
                'clientId' => 'mqttid1',
                'online'   => false,
            ],
            [
                'clientId' => 'mqttid2',
                'online'   => true,
            ],
        ];

        $thing_client = $this->getClient(compact('body'));

        parent::assertArraySubset($body, $thing_client->isOnlines('endpoint', ['mqttid1', 'mqttid2']));
    }

    private function getClient($response_options = [])
    {
        $status = $response_options['status'] ?? 200;

        if (isset($response_options['body'])) {
            $body = json_encode($response_options['body']);
        } else {
            $body = null;
        }

        return new Client(
            $this->getMockSigner(),
            $this->getMockHttpClient($status, $body)
        );
    }
}
