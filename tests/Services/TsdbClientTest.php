<?php

namespace Dzgrief\Bce\Tests;

use Dzgrief\Bce\HttpContentTypes;
use Dzgrief\Bce\Services\TsdbClient;
use Dzgrief\Bce\Signer;
use Dzgrief\Bce\Tests\Traits\Mockable;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TsdbClientTest extends TestCase
{
    use Mockable;

    public function testSetDataPoints()
    {
        $tsdb_client = $this->getTsdbClient(['status' => 201]);

        parent::assertNull($tsdb_client->setDataPoints([
            [
                'metric' => 'chlorine',
                'field' => 'value',
                'tags' => [
                    'host' => 'server1',
                    'rack' => 'rack1',
                ],
                'timestamp' => (int) (microtime(true) * 1000),
                'value' => 0.51,
            ],
        ]));
    }

    public function testGetMetrics()
    {
        $body = ['metrics' => ['chlorine', 'degree']];
        $tsdb_client = $this->getTsdbClient(compact('body'));

        parent::assertArraySubset($body, $tsdb_client->getMetrics());
    }

    public function testGetTags()
    {
        $body = ['tags' => ['rack' => ['rack1', 'rack2']]];
        $tsdb_client = $this->getTsdbClient(compact('body'));

        parent::assertArraySubset($body, $tsdb_client->getTags('chlorine'));
    }

    public function testGetDataPoints()
    {
        $body = [
            'results' => [
                [
                    'metric' => 'chlorine',
                    'field' => 'value',
                    'groups' => [
                        [
                            'groupInfos' => [],
                            'values' => [
                                [1509418134240, 0.44],
                            ],
                        ],
                    ],
                    'rawCount' => 1,
                ],
            ],
        ];

        $tsdb_client = $this->getTsdbClient(compact('body'));

        parent::assertArraySubset($body, $tsdb_client->getDataPoints([
            'metric' => 'chlorine',
            'field' => 'value',
            'filters' => [
                'start' => 0,
            ],
            'limit' => 1000,
        ]));
    }

    public function testGetFields()
    {
        $body = ['fields' => ['value' => ['type' => 'Number']]];
        $tsdb_client = $this->getTsdbClient(compact('body'));

        parent::assertArraySubset($body, $tsdb_client->getFields('chlorine'));
    }

    public function testExport()
    {
        $body = 'timestamp,chlorine\n1509418134240,0.44\n1509418148956,0.45';
        $headers['content-type'] = HttpContentTypes::CSV;
        $tsdb_client = $this->getTsdbClient(compact('body', 'headers'));

        parent::assertSame($body, $tsdb_client->export('', [
            'metrics' => ['chlorine'],
            'filters' => [
                'start' => 0,
            ],
        ]));
    }

    private function getTsdbClient($response_options = [])
    {
        $status = $response_options['status'] ?? 200;
        $headers = $response_options['headers'] ?? [];

        if (isset($response_options['body'])) {
            if (is_array($response_options['body'])) {
                $body = json_encode($response_options['body']);
            } else {
                $body = $response_options['body'];
            }
        } else {
            $body = null;
        }

        return new TsdbClient(
            $this->getMockSigner(),
            $this->getMockHttpClient($status, $body, $headers),
            'test'
        );
    }
}
