<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\PolicyClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class PolicyClientTest extends TestCase
{
    use Mockable;

    public function testGetPolicies()
    {
        $body = [
            'totalCount' => 1,
            'result'     => [
                [
                    'endpointName' => 'endpoint',
                    'policyName'   => 'policy',
                    'createTime'   => '2017-10-23T07:11:27Z',
                ],
            ],
            'order'      => 'desc',
            'orderBy'    => 'createtime',
            'pageSize'   => 50,
            'pageNo'     => 1,
        ];

        $policy_client = $this->getClient(PolicyClient::class, compact('body'));

        parent::assertArraySubset($body, $policy_client->getPolicies('endpoint', 'principal'));
    }

    public function testGetPolicy()
    {
        $body = [
            'endpointName' => 'endpoint',
            'policyName'   => 'policy',
            'createTime'   => '2017-10-23T07:11:27Z',
        ];

        $policy_client = $this->getClient(PolicyClient::class, compact('body'));

        parent::assertArraySubset($body, $policy_client->getPolicy('endpoint', 'policy'));
    }

    public function testSetPolicy()
    {
        $body = [
            'endpointName' => 'endpoint',
            'policyName'   => 'policy',
            'createTime'   => '2017-10-23T07:11:27Z',
        ];

        $policy_client = $this->getClient(PolicyClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $policy_client->setPolicy('endpoint', 'policy'));
    }

    public function testUnsetPolicy()
    {
        $policy_client = $this->getClient(PolicyClient::class, ['status' => 204]);

        parent::assertNull($policy_client->unsetPolicy('endpoint', 'policy'));
    }
}
