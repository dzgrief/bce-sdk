<?php

namespace Dzgrief\Bce\Services\IotHub;

class AuthenticationClient extends IotHubClient
{
    /**
     * 认证
     *
     * @param  string $username
     * @param  string $password
     * @return array
     */
    public function authenticate($username, $password)
    {
        $body = json_encode(compact('username', 'password'));

        return parent::request('POST', parent::SERVICE_HOST, '/v1/auth/authenticate/password', $body);
    }

    /**
     * 鉴权
     *
     * @param  string $principal_uuid
     * @param  string $action
     * @param  string $topic
     * @return array
     */
    public function authorize($principal_uuid, $action, $topic = '')
    {
        $body = json_encode([
            'principalUuid' => $principal_uuid,
            'action'        => $action,
            'topic'         => $topic,
        ]);

        return parent::request('POST', parent::SERVICE_HOST, '/v1/auth/authorize', $body);
    }
}
