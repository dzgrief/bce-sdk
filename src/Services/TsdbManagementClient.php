<?php

namespace Dzgrief\Bce\Services;

use Dzgrief\Bce\BaseClient;

class TsdbManagementClient extends BaseClient
{
    const SERVICE_HOST = 'tsdb.gz.baidubce.com';

    /**
     * 获取数据库信息
     *
     * @param  string $id
     * @return array
     */
    public function getDatabase($id)
    {
        return parent::request('GET', self::SERVICE_HOST, '/v1/database/' . $id);
    }

    /**
     * 获取数据库列表
     *
     * @return array
     */
    public function getDatabases()
    {
        return parent::request('GET', self::SERVICE_HOST, '/v1/database');
    }
}
