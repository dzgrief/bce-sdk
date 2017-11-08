<?php

namespace Dzgrief\Bce\Services\IotHub;

class EndpointClient extends IotHubClient
{
    /**
     * 获取 Endpoint 列表
     *
     * @param  array  $parameters
     * @return array
     */
    public function getEndpoints($parameters = [])
    {
        return parent::request('GET', parent::SERVICE_HOST, '/v1/endpoint', '', $parameters);
    }

    /**
     * 获取指定 Endpoint
     *
     * @param  string $name
     * @return array
     */
    public function getEndpoint($name)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$name}");
    }

    /**
     * 创建 Endpoint
     *
     * @param  string $name
     * @return array
     */
    public function setEndpoint($name)
    {
        return parent::request('POST', parent::SERVICE_HOST, '/v1/endpoint', json_encode(['endpointName' => $name]));
    }

    /**
     * 删除 Endpoint
     *
     * @param  string $name
     * @return void
     */
    public function unsetEndpoint($name)
    {
        parent::request('DELETE', parent::SERVICE_HOST, "/v1/endpoint/{$name}");
    }
}
