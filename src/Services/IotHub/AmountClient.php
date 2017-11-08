<?php

namespace Dzgrief\Bce\Services\IotHub;

class AmountClient extends IotHubClient
{
    /**
     * 获取当前账单月内使用量
     *
     * @return array
     */
    public function getUsage()
    {
        return parent::request('GET', parent::SERVICE_HOST, '/v1/usage');
    }

    /**
     * 获取当前账单月内特定实例的使用量
     *
     * @param  string $endpoint_name
     * @return array
     */
    public function getUsageByEndpoint($endpoint_name)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/usage");
    }

    /**
     * 获取特定实例某个时间段内的使用量
     *
     * @param  string $endpoint_name
     * @param  string $start
     * @param  string $end
     * @return array
     */
    public function getUsageByQuery($endpoint_name, $start, $end)
    {
        $parameters = compact('start', 'end');

        return parent::request('POST', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/usage-query", '', $parameters);
    }
}
