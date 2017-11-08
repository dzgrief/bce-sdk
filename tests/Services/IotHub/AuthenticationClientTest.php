<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\AuthenticationClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class AuthenticationClientTest extends TestCase
{
    use Mockable;

    public function testAuthenticate()
    {
        $body = [
            'endpointName'  => 'endpoint',
            'principalUuid' => 'df87a968-f1b5-461c-a3ea-75c73576c639',
            'endpointUuid'  => 'd1a2c1c6-42c1-39c2-a7e9-a360346b412b',
        ];

        $authentication_client = $this->getAuthenticationClient(compact('body'));
        $response = $authentication_client->authenticate('endpoint/thing', 'bw3qWSy2l1QgiePN3b7beWOVaGoObiR9ZefT70cKnBB=');

        parent::assertArraySubset($body, $response);
    }

    public function testAuthorize()
    {
        $body = ['message'  => 'ok'];
        $authentication_client = $this->getAuthenticationClient(compact('body'));
        $response = $authentication_client->authorize('df87a968-f1b5-461c-a3ea-75c73576c639', 'CONNECT');

        parent::assertArraySubset($body, $response);
    }

    private function getAuthenticationClient($response_options = [])
    {
        $status = $response_options['status'] ?? 200;

        if (isset($response_options['body'])) {
            $body = json_encode($response_options['body']);
        } else {
            $body = null;
        }

        return new AuthenticationClient(
            $this->getMockSigner(),
            $this->getMockHttpClient($status, $body)
        );
    }
}
