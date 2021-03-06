<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\ActionClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class ActionClientTest extends TestCase
{
    use Mockable;

    public function testSetPrincipal()
    {
        $body = ['message' => 'ok'];
        $thing_client = $this->getClient(ActionClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $thing_client->setPrincipal('endpoint', 'thing', 'principal'));
    }

    public function testUnsetPrincipal()
    {
        $body = ['message' => 'ok'];
        $thing_client = $this->getClient(ActionClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $thing_client->unsetPrincipal('endpoint', 'thing', 'principal'));
    }

    public function testSetPolicy()
    {
        $body = ['message' => 'ok'];
        $thing_client = $this->getClient(ActionClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $thing_client->setPolicy('endpoint', 'principal', 'policy'));
    }

    public function testUnsetPolicy()
    {
        $body = ['message' => 'ok'];
        $thing_client = $this->getClient(ActionClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $thing_client->unsetPolicy('endpoint', 'principal', 'policy'));
    }
}
