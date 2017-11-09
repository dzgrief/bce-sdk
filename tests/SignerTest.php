<?php

namespace Dzgrief\Bce\Tests;

use Dzgrief\Bce\Signer;
use PHPUnit\Framework\TestCase;

class SignerTest extends TestCase
{
    public function testSign()
    {
        $access_key_id = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $secret_access_key = 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
        $expiration_period_in_seconds = 1800;
        $signer = new Signer($access_key_id, $secret_access_key, $expiration_period_in_seconds);

        $parameters = [
            'partNumber' => 9,
            'uploadId'   => 'a44cc9bab11cbd156984767aad637851',
        ];

        $headers = [
            'x-bce-date'     => '2015-04-27T08:23:49Z',
            'content-type'   => 'text/plain',
            'content-length' => 8,
            'content-md5'    => 'NFzcPqhviddjRNnSOGo4rw==',
            'host'           => 'bj.bcebos.com',
        ];

        $auth_string = $signer->sign('PUT', '/v1/test/myfolder/readme.txt', $parameters, $headers);
        $auth_string_without_parameters = $signer->sign('PUT', '/v1/test/myfolder/readme.txt', [], $headers);

        parent::assertSame($auth_string, 'bce-auth-v1/aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/2015-04-27T08:23:49Z/1800//d74a04362e6a848f5b39b15421cb449427f419c95a480fd6b8cf9fc783e2999e');

        parent::assertSame($auth_string_without_parameters, 'bce-auth-v1/aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/2015-04-27T08:23:49Z/1800//0558aac491bbef484d3aaa30ac1e65d4ff10daccd351f15c91e922ee4ce72690');
    }
}
