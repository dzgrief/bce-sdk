<?php

namespace Dzgrief\Bce\Services\IotHub;

class ThingClient extends IotHubClient
{
    /**
     * 获取 Thing 列表
     *
     * @param  string $endpoint_name
     * @param  array  $parameters
     * @return array
     */
    public function getThings($endpoint_name, $parameters = [])
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/thing", '', $parameters);
    }

    /**
     * 获取指定 Thing
     *
     * @param  string $endpoint_name
     * @param  string $thing_name
     * @return array
     */
    public function getThing($endpoint_name, $thing_name)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/thing/{$thing_name}");
    }

    /**
     * 创建 Thing
     *
     * @param  string $endpoint_name
     * @param  string $thing_name
     * @return array
     */
    public function setThing($endpoint_name, $thing_name)
    {
        $body = json_encode(['thingName' => $thing_name]);

        return parent::request('POST', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/thing", $body);
    }

    /**
     * 删除 Thing
     *
     * @param  string $endpoint_name
     * @param  string $thing_name
     * @return void
     */
    public function unsetThing($endpoint_name, $thing_name)
    {
        parent::request('DELETE', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/thing/{$thing_name}");
    }
}
