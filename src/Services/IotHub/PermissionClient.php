<?php

namespace Dzgrief\Bce\Services\IotHub;

class PermissionClient extends IotHubClient
{
    /**
     * 获取 Permission 列表
     *
     * @param  string $endpoint_name
     * @param  string $policy_name
     * @param  array  $parameters
     * @return array
     */
    public function getPermissions($endpoint_name, $policy_name, $parameters = [])
    {
        $parameters['policyName'] = $policy_name;

        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/permission", '', $parameters);
    }

    /**
     * 获取指定 Permission
     *
     * @param  string $endpoint_name
     * @param  string $permission_uuid
     * @return array
     */
    public function getPermission($endpoint_name, $permission_uuid)
    {
        return parent::request('GET', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/permission/{$permission_uuid}");
    }

    /**
     * 创建 Permission
     *
     * @param  string $endpoint_name
     * @param  string $policy_name
     * @param  array  $operations
     * @param  string $topic
     * @return array
     */
    public function setPermission($endpoint_name, $policy_name, array $operations, $topic)
    {
        $body = json_encode([
            'policyName' => $policy_name,
            'operations' => $operations,
            'topic'      => $topic,
        ]);

        return parent::request('POST', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/permission", $body);
    }

    /**
     * 更新 Permission
     *
     * @param  string $endpoint_name
     * @param  string $permission_uuid
     * @param  array  $operations
     * @param  string $topic
     * @return array
     */
    public function updatePermission($endpoint_name, $permission_uuid, array $operations, $topic)
    {
        $body = json_encode([
            'operations' => $operations,
            'topic'      => $topic,
        ]);

        return parent::request('PUT', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/permission/{$permission_uuid}", $body);
    }

    /**
     * 删除 Permission
     *
     * @param  string $endpoint_name
     * @param  string $permission_uuid
     * @return void
     */
    public function unsetPermission($endpoint_name, $permission_uuid)
    {
        parent::request('DELETE', parent::SERVICE_HOST, "/v1/endpoint/{$endpoint_name}/permission/{$permission_uuid}");
    }
}
