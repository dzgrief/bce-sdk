<?php

namespace Dzgrief\Bce\Services\RuleEngine;

use Dzgrief\Bce\BaseClient;

class RuleEngineClient extends BaseClient
{
    const SERVICE_HOST = 're.iot.gz.baidubce.com';

    /**
     * 创建规则
     *
     * @param  array $parameters
     * @return array
     */
    public function setRule($parameters = [])
    {
        return parent::request('POST', self::SERVICE_HOST, '/v1/rules', json_encode($parameters));
    }

    /**
     * 获取规则列表
     *
     * @param  integer $page_no
     * @param  integer $page_size
     * @return array
     */
    public function getRules($page_no = 1, $page_size = 20)
    {
        $queries = [
            'pageNo'   => $page_no,
            'pageSize' => $page_size,
        ];

        return parent::request('GET', self::SERVICE_HOST, '/v1/rules', '', $queries);
    }

    /**
     * 设置规则目的地
     *
     * @param  string $rule_uuid
     * @param  string $kind
     * @param  string $value
     * @return array
     */
    public function setDestination($rule_uuid, $kind, $value)
    {
        $parameters = [
            'ruleUuid' => $rule_uuid,
            'kind'     => $kind,
            'value'    => $value,
        ];

        return parent::request('POST', self::SERVICE_HOST, '/v1/destinations', $parameters);
    }

    /**
     * 删除规则目的地
     *
     * @param  string $destination_uuid
     * @return void
     */
    public function unsetDestination($destination_uuid)
    {
        parent::request('DELETE', self::SERVICE_HOST, "/v1/destinations/{$destination_uuid}");
    }

    /**
     * 获取指定规则
     *
     * @param  string $rule_uuid
     * @return array
     */
    public function getRule($rule_uuid)
    {
        return parent::request('GET', self::SERVICE_HOST, "/v1/rules/{$rule_uuid}");
    }

    /**
     * 更新规则
     *
     * @param  string $rule_uuid
     * @param  array  $parameters
     * @return array
     */
    public function updateRule($rule_uuid, $parameters = [])
    {
        return parent::request('PUT', self::SERVICE_HOST, "/v1/rules/{$rule_uuid}", json_encode($parameters));
    }

    /**
     * 批量删除规则
     *
     * @param  array  $rule_uuids
     * @return array
     */
    public function unsetRules(array $rule_uuids)
    {
        $parameters['rules'] = $rule_uuids;

        return parent::request('POST', self::SERVICE_HOST, '/v1/rules/batch/delete', json_encode($parameters));
    }

    /**
     * 禁用规则
     *
     * @param  string $rule_uuid
     * @return void
     */
    public function disableRule($rule_uuid)
    {
        return parent::request('PUT', self::SERVICE_HOST, "/v1/rules/{$rule_uuid}/disable");
    }

    /**
     * 启用规则
     *
     * @param  string $rule_uuid
     * @return void
     */
    public function enableRule($rule_uuid)
    {
        return parent::request('PUT', self::SERVICE_HOST, "/v1/rules/{$rule_uuid}/enable");
    }
}
