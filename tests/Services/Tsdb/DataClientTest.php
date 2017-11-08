<?php

namespace Dzgrief\Bce\Tests\Services\Tsdb;

use Dzgrief\Bce\HttpContentTypes;
use Dzgrief\Bce\Services\Tsdb\DataClient;
use Dzgrief\Bce\Signer;
use Dzgrief\Bce\Tests\Traits\Mockable;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class DataClientTest extends TestCase
{
    use Mockable;

    public function testSetDataPoints()
    {
        $data_client = $this->getDataClient(['status' => 201]);

        parent::assertNull($data_client->setDataPoints([
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
        $data_client = $this->getDataClient(compact('body'));

        parent::assertArraySubset($body, $data_client->getMetrics());
    }

    public function testGetTags()
    {
        $body = ['tags' => ['rack' => ['rack1', 'rack2']]];
        $data_client = $this->getDataClient(compact('body'));

        parent::assertArraySubset($body, $data_client->getTags('chlorine'));
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

        $data_client = $this->getDataClient(compact('body'));

        parent::assertArraySubset($body, $data_client->getDataPoints([
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
        $data_client = $this->getDataClient(compact('body'));

        parent::assertArraySubset($body, $data_client->getFields('chlorine'));
    }

    public function testExport()
    {
        $body = 'timestamp,chlorine\n1509418134240,0.44\n1509418148956,0.45';
        $headers['content-type'] = HttpContentTypes::CSV;
        $data_client = $this->getDataClient(compact('body', 'headers'));

        parent::assertSame($body, $data_client->export('', [
            'metrics' => ['chlorine'],
            'filters' => [
                'start' => 0,
            ],
        ]));
    }

    private function getDataClient($response_options = [])
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

        return new DataClient(
            $this->getMockSigner(),
            'test',
            $this->getMockHttpClient($status, $body, $headers)
        );
    }
}
