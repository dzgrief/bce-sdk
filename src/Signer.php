<?php

namespace Dzgrief\Bce;

class Signer implements SignerInterface
{
    const VERSION = 'v1';

    protected $access_key_id;
    protected $secret_access_key;
    protected $expiration_period_in_seconds;

    public function __construct($access_key_id, $secret_access_key, $expiration_period_in_seconds = 1800)
    {
        $this->access_key_id = $access_key_id;
        $this->secret_access_key = $secret_access_key;
        $this->expiration_period_in_seconds = $expiration_period_in_seconds;
    }

    /**
     * 生成 BCE 请求签名字符串
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $parameters
     * @param  array  $headers
     * @return string
     */
    public function sign($method, $uri, $parameters, $headers)
    {
        $timestamp = $headers['x-bce-date'];
        $version = self::VERSION;
        $auth_string_prefix = "bce-auth-{$version}/{$this->access_key_id}/{$timestamp}/{$this->expiration_period_in_seconds}";
        $signature = $this->getSignature($method, $uri, $parameters, $headers, $auth_string_prefix);

        return "{$auth_string_prefix}//{$signature}";
    }

    /**
     * 获取签名
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $parameters
     * @param  array  $headers
     * @param  string $auth_string_prefix
     * @return string
     */
    protected function getSignature($method, $uri, $parameters, $headers, $auth_string_prefix)
    {
        $canonical_request = $this->getCanonicalRequest($method, $uri, $parameters, $headers);
        $signing_key = $this->getSigningKey($auth_string_prefix);

        return hash_hmac('sha256', $canonical_request, $signing_key);
    }

    /**
     * 获取请求字符串
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $parameters
     * @param  array  $headers
     * @return string
     */
    protected function getCanonicalRequest($method, $uri, $parameters, $headers)
    {
        if (count($parameters) > 0) {
            $parameter_string_array = [];
            ksort($parameters);

            foreach ($parameters as $key => $value) {
                $parameter_string_array[] = $this->urlEncode($key) . '=' . $this->urlEncode($value);
            }

            $parameter_string = implode('&', $parameter_string_array);
        } else {
            $parameter_string = '';
        }

        $header_string_array = [];
        ksort($headers);

        foreach ($headers as $key => $value) {
            $header_string_array[] = strtolower($key) . ':' . $this->urlEncode(trim($value));
        }

        $headers_string = implode("\n", $header_string_array);

        return $method . "\n" . $this->urlEncodeExceptSlash($uri) . "\n" . $parameter_string . "\n" . $headers_string;
    }

    /**
     * 签署密钥
     *
     * @param  string $auth_string_prefix
     * @return string
     */
    protected function getSigningKey($auth_string_prefix)
    {
        return hash_hmac('sha256', $auth_string_prefix, $this->secret_access_key);
    }

    /**
     * RFC 3986 规定编码
     *
     * @param  string $string
     * @return string
     */
    protected function urlEncode($string)
    {
        return rawurlencode($string);
    }

    /**
     * RFC 3986 规定编码，排除 `/` 字符
     *
     * @param  string $string
     * @return string
     */
    protected function urlEncodeExceptSlash($string)
    {
        return str_replace('%2F', '/', $this->urlEncode($string));
    }
}
