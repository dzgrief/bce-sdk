<?php

namespace Dzgrief\Bce\Tests\Services\Tsdb;

use Dzgrief\Bce\Services\Tsdb\ManagementClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class ManagementClientTest extends TestCase
{
    use Mockable;

    public function testGetDatabase()
    {
        $body = [
            'databaseId'   => 'tsdb-m2n239yzo1ag',
            'databaseName' => 'test',
            'description'  => '',
            'endpoint'     => 'test.tsdb.iot.gz.baidubce.com',
            'quota'        => ['ingestDataPointsMonthly' => 1],
            'status'       => 'Active',
            'autoExport'   => false,
            'createTime'   => '2017-10-31T01:59:13Z',
            'createTime'   => '2017-11-30T01:59:13Z',
        ];

        $management_client = $this->getManagementClient(compact('body'));

        parent::assertArraySubset($body, $management_client->getDatabase('testid'));
    }

    public function testGetDatabases()
    {
        $body = [
            'databases' => [
                'databaseId'   => 'tsdb-m2n239yzo1ag',
                'databaseName' => 'test',
                'description'  => '',
                'endpoint'     => 'test.tsdb.iot.gz.baidubce.com',
                'quota'        => ['ingestDataPointsMonthly' => 1],
                'status'       => 'Active',
                'autoExport'   => false,
                'createTime'   => '2017-10-31T01:59:13Z',
                'createTime'   => '2017-11-30T01:59:13Z',
            ],
        ];

        $management_client = $this->getManagementClient(compact('body'));

        parent::assertArraySubset($body, $management_client->getDatabases());
    }

    private function getManagementClient($response_options = [])
    {
        if (isset($response_options['body'])) {
            if (is_array($response_options['body'])) {
                $body = json_encode($response_options['body']);
            } else {
                $body = $response_options['body'];
            }
        } else {
            $body = null;
        }

        return new ManagementClient(
            $this->getMockSigner(),
            $this->getMockHttpClient(200, $body)
        );
    }
}

