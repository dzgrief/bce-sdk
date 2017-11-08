<?php

namespace Dzgrief\Bce\Services\IotHub;

class Client extends IotHubClient
{
    /**
     * 获取指定 MQTT 客户端在线状态
     *
     * @param  string  $endpoint_name
     * @param  string  $client_id
     * @return boolean
     */
    public function isOnline($endpoint_name, $client_id)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v2/endpoint/{$endpoint_name}/client/{$client_id}/status/online");
    }

    /**
     * 批量获取 MQTT 客户端在线状态
     *
     * @param  string  $endpoint_name
     * @param  array   $client_ids
     * @return boolean
     */
    public function isOnlines($endpoint_name, array $client_ids)
    {
        $body = json_encode($client_ids);

        return parent::request('POST', parent::SERVICE_HOST, "/v2/endpoint/{$endpoint_name}/batch-client-query/status", $body);
    }
}
