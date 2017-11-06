<?php

namespace Dzgrief\Bce;

interface SignerInterface
{
    /**
     * 生成 BCE 请求签名字符串
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $parameters
     * @param  array  $headers
     * @return string
     */
    public function sign($method, $uri, $parameters, $headers);
}
