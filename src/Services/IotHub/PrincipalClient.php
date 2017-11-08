<?php

namespace Dzgrief\Bce\Services\IotHub;

class PrincipalClient extends IotHubClient
{
    /**
     * 获取 Principal 列表
     *
     * @param  string $endpoint_name
     * @param  array  $parameters
     * @return array
     */
    public function getPrincipals($endpoint_name, $parameters = [])
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/principal", '', $parameters);
    }

    /**
     * 获取指定 Principal
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @return array
     */
    public function getPrincipal($endpoint_name, $principal_name)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/principal/{$principal_name}");
    }

    /**
     * 创建 Principal
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @return array
     */
    public function setPrincipal($endpoint_name, $principal_name)
    {
        $body = json_encode(['principalName' => $principal_name]);

        return parent::request('POST', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/principal", $body);
    }

    /**
     * 重新生成密钥
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @return array
     */
    public function resetPassword($endpoint_name, $principal_name)
    {
        return parent::request('POST', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/principal/{$principal_name}");
    }

    /**
     * 删除 Principal
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @return void
     */
    public function unsetPrincipal($endpoint_name, $principal_name)
    {
        parent::request('DELETE', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/principal/{$principal_name}");
    }
}
