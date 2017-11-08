<?php

namespace Dzgrief\Bce\Services\IotHub;

class PolicyClient extends IotHubClient
{
    /**
     * 获取 Policy 列表
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @param  array  $parameters
     * @return array
     */
    public function getPolicies($endpoint_name, $principal_name, $parameters = [])
    {
        $parameters['principal_name'] = $principal_name;

        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/policy", '', $parameters);
    }

    /**
     * 获取指定 Policy
     *
     * @param  string $endpoint_name
     * @param  string $policy_name
     * @return array
     */
    public function getPolicy($endpoint_name, $policy_name)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/policy/{$policy_name}");
    }

    /**
     * 创建 Policy
     *
     * @param  string $endpoint_name
     * @param  string $policy_name
     * @return array
     */
    public function setPolicy($endpoint_name, $policy_name)
    {
        $body = json_encode(['policyName' => $policy_name]);

        return parent::request('POST', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/policy", $body);
    }

    /**
     * 删除 Policy
     *
     * @param  string $endpoint_name
     * @param  string $policy_name
     * @return void
     */
    public function unsetPolicy($endpoint_name, $policy_name)
    {
        parent::request('DELETE', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/policy/{$policy_name}");
    }
}
