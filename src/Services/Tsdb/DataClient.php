<?php

namespace Dzgrief\Bce\Services\Tsdb;

use Dzgrief\Bce\BaseClient;
use Dzgrief\Bce\SignerInterface;

class DataClient extends BaseClient
{
    const SERVICE_HOST = 'tsdb.iot.gz.baidubce.com';

    protected $db_name;

    public function __construct(SignerInterface $signer, $db_name)
    {
        parent::__construct($signer);

        $this->db_name = $db_name;
    }

    /**
     * 写入数据点
     *
     * @param  array $datapoints
     * @return void
     */
    public function setDataPoints($datapoints)
    {
        parent::request('POST', $this->getHost(), '/v1/datapoint', json_encode(compact('datapoints')));
    }

    /**
     * 获取度量列表
     *
     * @return array
     */
    public function getMetrics()
    {
        return parent::request('GET', $this->getHost(), '/v1/metric');
    }

    /**
     * 获取标签列表
     *
     * @param  string $metric
     * @param  array  $parameters
     * @return array
     */
    public function getTags($metric, $parameters = [])
    {
        return parent::request('GET', $this->getHost(), "/v1/metric/{$metric}/tag", '', $parameters);
    }

    /**
     * 获取数据点列表
     *
     * @param  array  $parameters
     * @return array
     */
    public function getDataPoints($parameters = [])
    {
        return parent::request('PUT', $this->getHost(), '/v1/datapoint', json_encode(['queries' => [$parameters]]), ['query' => '']);
    }

    /**
     * 获取域列表
     *
     * @param  string $metric
     * @return array
     */
    public function getFields($metric)
    {
        return parent::request('GET', $this->getHost(), "/v1/metric/{$metric}/field");
    }

    /**
     * 导出数据
     *
     * @param  string $path
     * @param  array  $parameters
     * @return string|null
     */
    public function export($path = '', $parameters = [])
    {
        $queries = ['export' => ''];

        if (empty($path)) {
            $body = parent::request('PUT', $this->getHost(), '/v1/datapoint', json_encode($parameters), $queries);
            $content = '';

            while (! $body->eof()) {
                $content .= $body->read(1024);
            }

            return $content;
        }

        $options = ['sink' => $path];

        parent::request('PUT', $this->getHost(), '/v1/datapoint', json_encode($parameters), $queries, [], $options);
    }

    /**
     * 获取服务地址
     *
     * @return string
     */
    protected function getHost()
    {
        return $this->db_name . '.' . self::SERVICE_HOST;
    }
}
