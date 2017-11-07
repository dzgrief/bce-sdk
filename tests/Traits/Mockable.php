<?php

namespace Dzgrief\Bce\Tests\Traits;

use Dzgrief\Bce\HttpContentTypes;
use Dzgrief\Bce\Signer;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;

trait Mockable
{
    protected function getMockSigner()
    {
        $mock_signer = parent::createMock(Signer::class);
        $mock_signer->method('sign')->willReturn('bce-auth-v1/aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/2015-04-27T08:23:49Z/1800//d74a04362e6a848f5b39b15421cb449427f419c95a480fd6b8cf9fc783e2999e');

        return $mock_signer;
    }

    protected function getMockHttpClient($status = 200, $body = null, $headers = [])
    {
        $headers = array_merge(['content-type' => HttpContentTypes::JSON], $headers);
        $response = new Response($status, $headers, $body);

        $mock_http_client = parent::createMock(HttpClient::class);
        $mock_http_client->method('request')->willReturn($response);

        return $mock_http_client;
    }
}
