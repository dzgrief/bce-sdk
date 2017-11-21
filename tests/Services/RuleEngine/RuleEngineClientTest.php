<?php

namespace Dzgrief\Bce\Tests\Services\RuleEngine;

use Dzgrief\Bce\Services\RuleEngine\RuleEngineClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class RuleEngineClientTest extends TestCase
{
    use Mockable;

    public function testSetRule()
    {
        $body = [
            'endpoint'     => 'endpoint',
            'state'        => 'ENABLED',
            'from'         => 'topic',
            'description'  => '',
            'accountUuid'  => '12ac43bf05254deebe0adf8a88842523',
            'destinations' => [
                [
                    'uuid'     => '91cc78ba-b23b-41eb-8f3a-badf42b22061',
                    'ruleUuid' => 'b6f03c2b-9f7a-4dae-9297-b3b2bc329296',
                    'value'    => 'database',
                    'kind'     => 'TSDB',
                ],
            ],
            'select'       => "'test_metric' as metric, `degree` as _value, CURRENT_TIMESTAMP AS _timestamp, `id`",
            'name'         => 'rule',
            'where'        => '',
            'endpointUuid' => '22e252bc-90dd-43a4-b30c-cd3efb39e320',
            'uuid'         => 'a6306c4b-9f7a-4dae-9292-a3b2bc329088',
        ];

        $parameters = [
            'endpoint'     => 'endpoint',
            'from'         => 'topic',
            'name'         => 'rule',
            'description'  => '',
            'select'       => "'test_metric' as metric, `degree` as _value, CURRENT_TIMESTAMP AS _timestamp, `id`",
            'where'        => '',
            'destinations' => [
                [
                    'kind'  => 'TSDB',
                    'value' => 'database',
                ]
            ],
        ];

        $rule_engine_client = $this->getClient(RuleEngineClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $rule_engine_client->setRule($parameters));
    }

    public function testGetRules()
    {
        $body = [
            'totalCount' => 1,
            'result'     => [
                [
                    'endpoint'     => 'endpoint',
                    'state'        => 'ENABLED',
                    'from'         => 'topic',
                    'description'  => '',
                    'destinations' => [
                        [
                            'uuid'     => '91cc78ba-b23b-41eb-8f3a-badf42b22061',
                            'ruleUuid' => 'b6f03c2b-9f7a-4dae-9297-b3b2bc329296',
                            'value'    => 'database',
                            'kind'     => 'TSDB',
                        ],
                    ],
                    'select'       => "'test_metric' as metric, `degree` as _value, CURRENT_TIMESTAMP AS _timestamp, `id`",
                    'name'         => 'rule',
                    'createTime'   => '2017-11-21T07:21:38Z',
                    'where'        => '',
                    'updateTime'   => '2017-11-21T07:21:38Z',
                    'endpointUuid' => '22e252bc-90dd-43a4-b30c-cd3efb39e320',
                    'uuid'         => 'a6306c4b-9f7a-4dae-9292-a3b2bc329088',
                ],
            ],
            'order'      => 'desc',
            'orderBy'    => 'createtime',
            'pageSize'   => 1,
            'pageNo'     => 1,
        ];

        $rule_engine_client = $this->getClient(RuleEngineClient::class, compact('body'));

        parent::assertArraySubset($body, $rule_engine_client->getRules(1, 1));
    }

    public function testSetDestination()
    {
        $body = [
            'kind'  => 'TSDB',
            'value' => 'database',
            'uuid'  => '110f289a-42d5-4840-a331-f5e588d43822',
        ];

        $rule_engine_client = $this->getClient(RuleEngineClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $rule_engine_client->setDestination('a6306c4b-9f7a-4dae-9292-a3b2bc329088', 'TSDB', 'database'));
    }

    public function testUnsetDestination()
    {
        $rule_engine_client = $this->getClient(RuleEngineClient::class, ['status' => 204]);

        parent::assertNull($rule_engine_client->unsetDestination('110f289a-42d5-4840-a331-f5e588d43822'));
    }

    public function testGetRule()
    {
        $body = [
            'endpoint'     => 'endpoint',
            'state'        => 'ENABLED',
            'from'         => 'topic',
            'description'  => '',
            'destinations' => [
                [
                    'uuid'     => '91cc78ba-b23b-41eb-8f3a-badf42b22061',
                    'ruleUuid' => 'b6f03c2b-9f7a-4dae-9297-b3b2bc329296',
                    'value'    => 'database',
                    'kind'     => 'TSDB',
                ],
            ],
            'select'       => "'test_metric' as metric, `degree` as _value, CURRENT_TIMESTAMP AS _timestamp, `id`",
            'name'         => 'rule',
            'createTime'   => '2017-11-21T07:21:38Z',
            'where'        => '',
            'updateTime'   => '2017-11-21T07:21:38Z',
            'endpointUuid' => '22e252bc-90dd-43a4-b30c-cd3efb39e320',
            'uuid'         => 'a6306c4b-9f7a-4dae-9292-a3b2bc329088',
        ];

        $rule_engine_client = $this->getClient(RuleEngineClient::class, compact('body'));

        parent::assertArraySubset($body, $rule_engine_client->getRule('a6306c4b-9f7a-4dae-9292-a3b2bc329088'));
    }

    public function testUpdateRule()
    {
        $body = [
            'endpoint'     => 'endpoint',
            'state'        => 'ENABLED',
            'from'         => 'topic',
            'description'  => '',
            'accountUuid'  => '12ac43bf05254deebe0adf8a88842523',
            'destinations' => [
                [
                    'uuid'     => '91cc78ba-b23b-41eb-8f3a-badf42b22061',
                    'ruleUuid' => 'b6f03c2b-9f7a-4dae-9297-b3b2bc329296',
                    'value'    => 'database',
                    'kind'     => 'TSDB',
                ],
            ],
            'select'       => "'test_metric' as metric, `degree` as _value, CURRENT_TIMESTAMP AS _timestamp, `id`",
            'name'         => 'rule',
            'where'        => '',
            'endpointUuid' => '22e252bc-90dd-43a4-b30c-cd3efb39e320',
            'uuid'         => 'a6306c4b-9f7a-4dae-9292-a3b2bc329088',
        ];

        $parameters = [
            'from'        => 'topic',
            'description' => '',
            'select'      => "'test_metric' as metric, `degree` as _value, CURRENT_TIMESTAMP AS _timestamp, `id`",
            'where'       => '',
        ];

        $rule_engine_client = $this->getClient(RuleEngineClient::class, compact('body'));

        parent::assertArraySubset($body, $rule_engine_client->updateRule('a6306c4b-9f7a-4dae-9292-a3b2bc329088', $parameters));
    }

    public function testUnsetRules()
    {
        $body = ['message' => 'ok'];
        $rule_engine_client = $this->getClient(RuleEngineClient::class, compact('body'));

        parent::assertArraySubset($body, $rule_engine_client->unsetRules(['a6306c4b-9f7a-4dae-9292-a3b2bc329088']));
    }

    public function testDisableRule()
    {
        $body = ['message' => 'ok'];
        $rule_engine_client = $this->getClient(RuleEngineClient::class, compact('body'));

        parent::assertArraySubset($body, $rule_engine_client->disableRule('a6306c4b-9f7a-4dae-9292-a3b2bc329088'));
    }

    public function testEnableRule()
    {
        $body = ['message' => 'ok'];
        $rule_engine_client = $this->getClient(RuleEngineClient::class, compact('body'));

        parent::assertArraySubset($body, $rule_engine_client->enableRule('a6306c4b-9f7a-4dae-9292-a3b2bc329088'));
    }
}
