<?php

namespace Dzgrief\Bce;

use DateTime;
use DateTimeZone;
use GuzzleHttp\ClientInterface;

class BaseClient extends SimpleHttpClient
{
    protected $signer;

    public function __construct(SignerInterface $signer, ClientInterface $http_client = null)
    {
        parent::__construct($http_client);

        $this->signer = $signer;
    }

    /**
     * 发送请求到 BCE
     *
     * @param  string $method
     * @param  string $host
     * @param  string $uri
     * @param  string $body
     * @param  array  $parameters
     * @param  array  $headers
     * @param  array  $options
     * @return array|\GuzzleHttp\Psr7\Stream
     */
    public function request($method, $host, $uri, $body = '', $parameters = [], $headers = [], $options = [])
    {
        $method = strtoupper($method);
        $body = is_array($body) ? json_encode($body, JSON_FORCE_OBJECT) : $body;
        $timestamp = $this->getTimestamp();
        $headers['x-bce-date'] = $timestamp;
        $headers['host'] = $host;
        $headers['content-length'] = strlen($body);
        $headers['content-type'] = HttpContentTypes::JSON;
        $headers['authorization'] = $this->signer->sign($method, $uri, $parameters, $headers);

        $options = array_merge([
            'headers'  => $headers,
            'body'     => $body,
            'query'    => $parameters,
        ], $options);

        return parent::request($method, $host, $uri, $options);
    }

    /**
     * 获取当前 UTC 时区时间
     *
     * @return string
     */
    protected function getTimestamp()
    {
        $timestamp = new DateTime();
        $timestamp->setTimezone(new DateTimeZone('UTC'));

        return $timestamp->format('Y-m-d\TH:i:s\Z');
    }
}
