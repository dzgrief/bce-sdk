<h1 align="center">Baidu Cloud SDK for PHP</h1>

[![Latest Stable Version](https://poser.pugx.org/dzgrief/bce-sdk/v/stable)](https://packagist.org/packages/dzgrief/bce-sdk)
[![Build Status](https://travis-ci.org/dzgrief/bce-sdk.svg?branch=master)](https://travis-ci.org/dzgrief/bce-sdk)
[![Coverage Status](https://coveralls.io/repos/github/dzgrief/bce-sdk/badge.svg?branch=master)](https://coveralls.io/github/dzgrief/bce-sdk?branch=master)
[![License](https://poser.pugx.org/dzgrief/bce-sdk/license)](https://packagist.org/packages/dzgrief/bce-sdk)

## 要求

- PHP >= 7.0

## 安装

```shell
$ composer require dzgrief/bce-sdk
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
| :-------- | :-------- |
| 时序数据库 TSDB 数据接口 | v1 |
| 时序数据库 TSDB 管理接口 | v1 |
| 物接入 Iot Hub Endpoint 接口 | v1 |
| 物接入 Iot Hub Thing 接口 | v1 |
| 物接入 Iot Hub Principal 接口 | v1 |
| 物接入 Iot Hub Policy 接口 | v1 |
| 物接入 Iot Hub Permission 接口 | v1 |
| 物接入 Iot Hub 认证接口 | v1 |
| 物接入 Iot Hub 动作接口 | v1 |
| 物接入 Iot Hub Client 接口 | v2 |
| 物接入 Iot Hub MQTT Client 接口 | v1 |
| 物接入 Iot Hub 使用量接口 | v1 |
| 规则引擎 Rule Engine 接口 | v1 |

## 接口参考

### 时序数据库 TSDB

- 数据接口

```php
$data_client = new \Dzgrief\Bce\Services\Tsdb\DataClient($signer, $tsdb_name);
$data_client->setDataPoints(datapoints);
$data_client->getMetrics(parameters);
$data_client->getTags(metric, parameters);
$data_client->getDataPoints(parameters);
$data_client->getFields(metric);
$data_client->export(path, parameters);
```

- 管理接口

```php
$management_client = new \Dzgrief\Bce\Services\Tsdb\ManagementClient($signer);
$management_client->getDatabase(id);
$management_client->getDatabases();
```

### Iot Hub

- Endpoint

```php
$endpoint_client = new \Dzgrief\Bce\Services\IotHub\EndpointClient($signer);
$endpoint_client->getEndpoints(parameters);
$endpoint_client->getEndpoint(endpoint);
$endpoint_client->setEndpoint(endpoint);
$endpoint_client->unsetEndpoint(endpoint);
```

- Thing

```php
$thing_client = new \Dzgrief\Bce\Services\IotHub\ThingClient($signer);
$thing_client->getThings(endpoint, parameters);
$thing_client->getThing(endpoint, thing);
$thing_client->setThing(endpoint, thing);
$thing_client->unsetThing(endpoint, thing);
```

- Principal

```php
$principal_client = \Dzgrief\Bce\Services\IotHub\PrincipalClient($signer);
$principal_client->getPrincipals(endpoint);
$principal_client->getPrincipal(endpoint, principal);
$principal_client->setPrincipal(endpoint, principal);
$principal_client->resetPassword(endpoint, principal);
$principal_client->unsetPrincipal(endpoint, principal);
```

- Policy

```php
$policy_client = \Dzgrief\Bce\Services\IotHub\PolicyClient($signer);
$policy_client->getPolicies(endpoint, principal, parameters);
$policy_client->getPolicy(endpoint, policy);
$policy_client->setPolicy(endpoint, policy);
$policy_client->unsetPolicy(endpoint, policy);
```

- Permission

```php
$permission_client = \Dzgrief\Bce\Services\IotHub\PermissionClient($signer);
$permission_client->getPermissions(endpoint, policy, parameters);
$permission_client->getPermission(endpoint, permission_uuid);
$permission_client->setPermission(endpoint, policy, operations, topic);
$permission_client->updatePermission(endpoint, permission_uuid, operations, topic);
$permission_client->unsetPermission(endpoint, permission_uuid);
```

- 认证

```php
$authentication_client = \Dzgrief\Bce\Services\IotHub\AuthenticationClient($signer);
$authentication_client->authenticate(username, password);
$authentication_client->authorize(principal_uuid, action, topic);
```

- 动作

```php
$action_client = \Dzgrief\Bce\Services\IotHub\ActionClient($signer);
$action_client->unsetPrincipal(endpoint, thing_name, principal);
$action_client->setPrincipal(endpoint, thing_name, principal);
$action_client->setPolicy(endpoint, principal, policy);
$action_client->unsetPolicy(endpoint, principal, policy);
```

- Client

```php
$client = \Dzgrief\Bce\Services\IotHub\Client($signer);
$client->isOnline(endpoint, client_id);
$client->isOnlines(endpoint, client_ids);
```

- MQTT Client

```php
$mqtt_client = \Dzgrief\Bce\Services\IotHub\MqttClient($username, $password);
$mqtt_client->publishMessage(message, qos, topic, retain);
```

- 使用量

```php
$amount_client = \Dzgrief\Bce\Services\IotHub\AmountClient($signer);
$amount_client->getUsage();
$amount_client->getUsageByEndpoint(endpoint);
$amount_client->getUsageByQuery(endpoint, start_date, end_date);
```
   
### Rule Engine

```
$rule_engine_client = \Dzgrief\Bce\Services\RuleEngine\RuleEngineClient($signer);
$rule_engine_client->setRule(parameters);
$rule_engine_client->getRules(page_no, page_size);
$rule_engine_client->setDestination(rule_uuid, kind, value);
$rule_engine_client->unsetDestination(destination_uuid);
$rule_engine_client->getRule(rule_uuid);
$rule_engine_client->updateRule(rule_uuid, parameters);
$rule_engine_client->unsetRules(rule_uuids);
$rule_engine_client->disableRule(rule_uuid);
$rule_engine_client->enableRule(rule_uuid);
```

### 详细参数参考

- [百度时序数据库 TSDB 接口文档](https://cloud.baidu.com/doc/TSDB/API.html)
- [百度物接入 Iot Hub 接口文档](https://cloud.baidu.com/doc/IOT/API.html)
- [规则引擎 Rule Engine 接口文档](https://cloud.baidu.com/doc/RE/API.html)

## 代码许可

The MIT License (MIT) 详情见 [License文件](https://github.com/dzgrief/bce-sdk/blob/master/LICENSE)