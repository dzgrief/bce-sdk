<h1 align="center">Baidu Cloud SDK for PHP</h1>

[![Latest Stable Version](https://poser.pugx.org/dzgrief/bce-sdk/v/stable)](https://packagist.org/packages/dzgrief/bce-sdk)
[![Build Status](https://travis-ci.org/dzgrief/bce-sdk.svg?branch=master)](https://travis-ci.org/dzgrief/bce-sdk)
[![License](https://poser.pugx.org/dzgrief/bce-sdk/license)](https://packagist.org/packages/dzgrief/bce-sdk)

## 要求

- PHP >= 7.0

## 安装

```shell
$ composer require "dzgrief/bce-sdk"
```

## 使用

```php
use Dzgrief\Bce\Services\TsdbClient;
use Dzgrief\Bce\Signer;

$access_key_id = 'xxxxxx';
$secret_access_key = 'xxxxxx';
$tsdb_name = 'xxx';

$signer = new Signer($access_key_id, $secret_access_key);
$tsdb_client = new TsdbClient($signer, $tsdb_name);

// 写入数据点
$tsdb_client->setDataPoints([
    [
        'metric' => 'chlorine',
        'field' => 'value',
        'tags' => [
            'host' => 'server1',
            'rack' => 'rack1',
        ],
        'timestamp' => (int) (microtime(true) * 1000),
        'value' => 0.32,
    ],
    [
        'metric' => 'chlorine',
        'field' => 'value',
        'tags' => [
            'host' => 'server2',
            'rack' => 'rack2',
        ],
        'timestamp' => (int) (microtime(true) * 1000),
        'value' => 0.23,
    ],
]);

// 获取标签列表
$tags = $tsdb_client->getTags('chlorine');
var_dump($tags);

```

## 支持接口版本

| 产品 | 版本 |
| :--------: | :--------: |
| 时序数据库 TSDB 数据接口 | v1 |
| 时序数据库 TSDB 管理接口 | v1 |

## 接口参考

-  时序数据库 TSDB 数据接口

```php
$tsdb_client = new \Dzgrief\Bce\Services\TsdbClient($signer, $tsdb_name);
$tsdb_client->setDataPoints($datapoints);
$tsdb_client->getMetrics();
$tsdb_client->getTags($metric, $parameters = []);
$tsdb_client->getDataPoints($parameters = []);
$tsdb_client->getFields($metric);
$tsdb_client->export($path = '', $parameters = []);
```

- 时序数据库 TSDB 管理接口

```php
$tsdb_management_client = new \Dzgrief\Bce\Services\TsdbManagementClient($signer);
$tsdb_management_client->getDatabase($id);
$tsdb_management_client->getDatabases();
```
   
- 详细参数参考
    - [百度时序数据库 TSDB 数据接口文档](https://cloud.baidu.com/doc/TSDB/API.html#.E6.95.B0.E6.8D.AEAPI.E6.8E.A5.E5.8F.A3.E8.AF.B4.E6.98.8E)
    - [百度时序数据库 TSDB 管理接口文档](https://cloud.baidu.com/doc/TSDB/API.html#.E7.AE.A1.E7.90.86API.E6.8E.A5.E5.8F.A3.E8.AF.B4.E6.98.8E)

## 代码许可

The MIT License (MIT) 详情见 [License文件](https://github.com/dzgrief/bce-sdk/blob/master/LICENSE)