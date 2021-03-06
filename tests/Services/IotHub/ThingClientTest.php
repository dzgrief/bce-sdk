<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\ThingClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class ThingClientTest extends TestCase
{
    use Mockable;

    public function testGetThings()
    {
        $body = [
            'totalCount' => 1,
            'result'     => [
                [
                    'username'     => 'endpoint/thing',
                    'thingName'    => 'thing',
                    'endpointName' => 'endpoint',
                    'createTime'   => '2017-10-23T07:13:26Z',
                ],
            ],
            'order'      => 'desc',
            'orderBy'    => 'createtime',
            'pageSize'   => 50,
            'pageNo'     => 1,
        ];

        $thing_client = $this->getClient(ThingClient::class, compact('body'));

        parent::assertArraySubset($body, $thing_client->getThings('endpoint'));
    }

    public function testGetThing()
    {
        $body = [
            'username'     => 'endpoint/thing',
            'thingName'    => 'thing',
            'endpointName' => 'endpoint',
            'createTime'   => '2017-10-23T07:13:26Z',
        ];

        $thing_client = $this->getClient(ThingClient::class, compact('body'));

        parent::assertArraySubset($body, $thing_client->getThing('endpoint', 'thing'));
    }

    public function testSetThing()
    {
        $body = [
            'username'     => 'endpoint/thing',
            'thingName'    => 'thing',
            'endpointName' => 'endpoint',
            'createTime'   => '2017-10-23T07:13:26Z',
        ];

        $thing_client = $this->getClient(ThingClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $thing_client->setThing('endpoint', 'thing'));
    }

    public function testUnsetThing()
    {
        $thing_client = $this->getClient(ThingClient::class, ['status' => 204]);

        parent::assertNull($thing_client->unsetThing('endpoint', 'thing'));
    }
}
