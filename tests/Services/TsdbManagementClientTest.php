<?php

namespace Dzgrief\Bce\Tests\Service;

use Dzgrief\Bce\Services\TsdbManagementClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class TsdbManagementClientTest extends TestCase
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

        $tsdb_management_client = $this->getTsdbManagementClient(compact('body'));

        parent::assertArraySubset($body, $tsdb_management_client->getDatabase('testid'));
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

        $tsdb_management_client = $this->getTsdbManagementClient(compact('body'));

        parent::assertArraySubset($body, $tsdb_management_client->getDatabases());
    }

    private function getTsdbManagementClient($response_options = [])
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

        return new TsdbManagementClient(
            $this->getMockSigner(),
            $this->getMockHttpClient(200, $body)
        );
    }
}

