<?php

namespace Dzgrief\Bce\Tests;

use Dzgrief\Bce\BaseClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class BaseClientTest extends TestCase
{
    use Mockable;

    public function testRequest()
    {
        $body = ['fields' => ['value' => ['type' => 'Number']]];

        $mock_http_client = $this->getMockHttpClient(200, json_encode($body));
        $base_client = new BaseClient($this->getMockSigner());
        $base_client->setHttpClient($mock_http_client);

        parent::assertArraySubset($body, $base_client->request('GET', 'test.tsdb.iot.gz.baidubce.com', '/v1/metric'));
    }
}
