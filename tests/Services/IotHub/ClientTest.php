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
        $thing_client = $this->getClient(Client::class, compact('body'));

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

        $thing_client = $this->getClient(Client::class, compact('body'));

        parent::assertArraySubset($body, $thing_client->isOnlines('endpoint', ['mqttid1', 'mqttid2']));
    }
}
