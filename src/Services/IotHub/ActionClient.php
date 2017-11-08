<?php

namespace Dzgrief\Bce\Services\IotHub;

class ActionClient extends IotHubClient
{
    /**
     * 给一个 Thing 添加一个 Principal
     *
     * @param  string $endpoint_name
     * @param  string $thing_name
     * @param  string $principal_name
     * @return array
     */
    public function setPrincipal($endpoint_name, $thing_name, $principal_name)
    {
        $body = json_encode([
            'endpointName'  => $endpoint_name,
            'thingName'     => $thing_name,
            'principalName' => $principal_name,
        ]);

        return parent::request('POST', parent::SERVICE_HOST, '/v1/action/attach-thing-principal', $body);
    }

    /**
     * 从一个 Thing 移除一个 Principal
     *
     * @param  string $endpoint_name
     * @param  string $thing_name
     * @param  string $principal_name
     * @return array
     */
    public function unsetPrincipal($endpoint_name, $thing_name, $principal_name)
    {
        $body = json_encode([
            'endpointName'  => $endpoint_name,
            'thingName'     => $thing_name,
            'principalName' => $principal_name,
        ]);

        return parent::request('POST', parent::SERVICE_HOST, '/v1/action/remove-thing-principal', $body);
    }

    /**
     * 给一个 Principal 添加一个 Policy
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @param  string $policy_name
     * @return array
     */
    public function setPolicy($endpoint_name, $principal_name, $policy_name)
    {
        $body = json_encode([
            'endpointName'  => $endpoint_name,
            'principalName' => $principal_name,
            'policyName'    => $policy_name,
        ]);

        return parent::request('POST', parent::SERVICE_HOST, '/v1/action/attach-principal-policy', $body);
    }

    /**
     * 从一个 Principal 移除一个 Policy
     *
     * @param  string $endpoint_name
     * @param  string $principal_name
     * @param  string $policy_name
     * @return array
     */
    public function unsetPolicy($endpoint_name, $principal_name, $policy_name)
    {
        $body = json_encode([
            'endpointName'  => $endpoint_name,
            'principalName' => $principal_name,
            'policyName'    => $policy_name,
        ]);

        return parent::request('POST', parent::SERVICE_HOST, '/v1/action/remove-principal-policy', $body);
    }
}
