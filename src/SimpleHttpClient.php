<?php

namespace Dzgrief\Bce;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;

class SimpleHttpClient
{
    protected $http_client;

    public function __construct()
    {
        $this->http_client = new HttpClient();
    }

    /**
     * 发送请求到 BCE
     *
     * @param  string $method
     * @param  string $host
     * @param  string $uri
     * @param  array  $options
     * @return array|\GuzzleHttp\Psr7\Stream
     */
    public function request($method, $host, $uri, $options = [])
    {
        $method = strtoupper($method);
        $response = $this->http_client->request($method, 'http://' . $host . $uri, $options);
        $content_types = $response->getHeader('Content-Type');

        foreach ($content_types as $key => $content_type) {
            $content_types[$key] = strtolower(str_replace(' ', '', $content_type));
        }

        if (in_array(HttpContentTypes::JSON, $content_types)) {
            return json_decode($response->getBody()->getContents(), true);
        }

        return $response->getBody();
    }

    /**
     * 设置 HttpClient
     *
     * @param  \GuzzleHttp\ClientInterface $http_client
     * @return $this
     */
    public function setHttpClient(ClientInterface $http_client)
    {
        $this->http_client = $http_client;

        return $this;
    }
}
