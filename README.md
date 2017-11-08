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
use Dzgrief\Bce\Services\Tsdb\DataClient;
use Dzgrief\Bce\Signer;

$access_key_id = 'xxxxxx';
$secret_access_key = 'xxxxxx';
$tsdb_name = 'xxx';

$signer = new Signer($access_key_id, $secret_access_key);
$data_client = new DataClient($signer, $tsdb_name);

// 写入数据点
$data_client->setDataPoints([
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
$tags = $data_client->getTags('chlorine');
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
$data_client = new \Dzgrief\Bce\Services\Tsdb\DataClient($signer, $tsdb_name);
$data_client->setDataPoints($datapoints);
$data_client->getMetrics();
$data_client->getTags($metric, $parameters = []);
$data_client->getDataPoints($parameters = []);
$data_client->getFields($metric);
$data_client->export($path = '', $parameters = []);
```

- 时序数据库 TSDB 管理接口

```php
$management_client = new \Dzgrief\Bce\Services\Tsdb\ManagementClient($signer);
$management_client->getDatabase($id);
$management_client->getDatabases();
```
   
- 详细参数参考
    - [百度时序数据库 TSDB 数据接口文档](https://cloud.baidu.com/doc/TSDB/API.html#.E6.95.B0.E6.8D.AEAPI.E6.8E.A5.E5.8F.A3.E8.AF.B4.E6.98.8E)
    - [百度时序数据库 TSDB 管理接口文档](https://cloud.baidu.com/doc/TSDB/API.html#.E7.AE.A1.E7.90.86API.E6.8E.A5.E5.8F.A3.E8.AF.B4.E6.98.8E)

## 代码许可

The MIT License (MIT) 详情见 [License文件](https://github.com/dzgrief/bce-sdk/blob/master/LICENSE)