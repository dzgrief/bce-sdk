<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\PermissionClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class PermissionClientTest extends TestCase
{
    use Mockable;

    public function testGetPermissions()
    {
        $body = [
            'totalCount' => 1,
            'result'     => [
                [
                    'policyUuid'     => 'df87a968-f1b5-461c-a3ea-75c73576c639',
                    'operations'     => ['SUBSCRIBE'],
                    'topic'          => 'topic',
                    'createTime'     => '2017-10-23T07:11:28Z',
                    'permissionUuid' => 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3',
                ],
            ],
            'order'      => 'desc',
            'orderBy'    => 'createtime',
            'pageSize'   => 50,
            'pageNo'     => 1,
        ];

        $permission_client = $this->getClient(PermissionClient::class, compact('body'));

        parent::assertArraySubset($body, $permission_client->getPermissions('endpoint', 'policy'));
    }

    public function testGetPermission()
    {
        $body = [
            'policyUuid'     => 'df87a968-f1b5-461c-a3ea-75c73576c639',
            'operations'     => ['SUBSCRIBE'],
            'topic'          => 'topic',
            'createTime'     => '2017-10-23T07:11:28Z',
            'permissionUuid' => 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3',
        ];

        $permission_client = $this->getClient(PermissionClient::class, compact('body'));

        parent::assertArraySubset($body, $permission_client->getPermission('endpoint', 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3'));
    }

    public function testSetPermission()
    {
        $body = [
            'policyUuid'     => 'df87a968-f1b5-461c-a3ea-75c73576c639',
            'operations'     => ['SUBSCRIBE'],
            'topic'          => 'topic',
            'createTime'     => '2017-10-23T07:11:28Z',
            'permissionUuid' => 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3',
        ];

        $permission_client = $this->getClient(PermissionClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $permission_client->setPermission('endpoint', 'policy', ['SUBSCRIBE'], 'topic'));
    }

    public function testUpdatePermission()
    {
        $body = [
            'policyUuid'     => 'df87a968-f1b5-461c-a3ea-75c73576c639',
            'operations'     => ['SUBSCRIBE'],
            'topic'          => 'topic',
            'createTime'     => '2017-10-23T07:11:28Z',
            'permissionUuid' => 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3',
        ];

        $permission_client = $this->getClient(PermissionClient::class, ['status' => 201, 'body' => $body]);
        $permission = $permission_client->updatePermission('endpoint', 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3', ['SUBSCRIBE'], 'topic');

        parent::assertArraySubset($body, $permission);
    }

    public function testUnsetPermission()
    {
        $permission_client = $this->getClient(PermissionClient::class, ['status' => 204]);

        parent::assertNull($permission_client->unsetPermission('endpoint', 'b82f0f31-9d3a-43f2-8d1c-2cbaf27b1ed3'));
    }
}
