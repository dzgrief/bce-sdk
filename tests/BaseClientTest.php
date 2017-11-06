<?php

namespace Dzgrief\Bce\Tests;

use Dzgrief\Bce\BaseClient;
use Dzgrief\Bce\Signer;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BaseClientTest extends TestCase
{
    public function testRequest()
    {
        $body = ['fields' => ['value' => ['type' => 'Number']]];
        $auth_string = 'bce-auth-v1/aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/2015-04-27T08:23:49Z/1800//d74a04362e6a848f5b39b15421cb449427f419c95a480fd6b8cf9fc783e2999e';

        $mock_signer = parent::createMock(Signer::class);
        $mock_signer->method('sign')->willReturn($auth_string);

        $mock_http_client = parent::createMock(HttpClient::class);
        $mock_http_client->method('request')->willReturn(new Response(200, [], json_encode($body)));

        $base_client = new BaseClient($mock_signer, $mock_http_client);

        parent::assertArraySubset($body, $base_client->request('GET', 'test.tsdb.iot.gz.baidubce.com', '/v1/metric'));
    }
}
