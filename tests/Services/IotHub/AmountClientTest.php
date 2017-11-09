<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\AmountClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class AmountClientTest extends TestCase
{
    use Mockable;

    public function testGetUsage()
    {
        $body = [
            'publishReceived' => 69,
            'publishSent'     => 16,
        ];

        $thing_client = $this->getClient(AmountClient::class, compact('body'));

        parent::assertArraySubset($body, $thing_client->getUsage());
    }

    public function testGetUsageByEndpoint()
    {
        $body = [
            'publishReceived' => 11,
            'publishSent'     => 3,
        ];

        $thing_client = $this->getClient(AmountClient::class, compact('body'));

        parent::assertArraySubset($body, $thing_client->getUsageByEndpoint('endpoint'));
    }

    public function testGetUsageByQuery()
    {
        $body = [
            'value' => [
                [
                    'date'  => '2017-01-01',
                    'usage' => [
                        'publishReceived' => 0,
                        'publishSent'     => 0,
                    ],
                ],
                [
                    'date'  => '2017-01-02',
                    'usage' => [
                        'publishReceived' => 0,
                        'publishSent'     => 0,
                    ],
                ],
            ],
        ];

        $thing_client = $this->getClient(AmountClient::class, compact('body'));

        parent::assertArraySubset($body, $thing_client->getUsageByQuery('endpoint', '2017-01-01', '2017-01-02'));
    }
}
