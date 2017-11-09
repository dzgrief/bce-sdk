<?php

namespace Dzgrief\Bce\Tests\Services\IotHub;

use Dzgrief\Bce\Services\IotHub\PrincipalClient;
use Dzgrief\Bce\Tests\Traits\Mockable;
use PHPUnit\Framework\TestCase;

class PrincipalClientTest extends TestCase
{
    use Mockable;

    public function testGetPrincipals()
    {
        $body = [
            'totalCount' => 1,
            'result'     => [
                [
                    'principalName' => 'principal',
                    'endpointName'  => 'endpoint',
                    'createTime'    => '2017-10-23T07:12:51Z',
                ],
            ],
            'order'      => 'desc',
            'orderBy'    => 'createtime',
            'pageSize'   => 50,
            'pageNo'     => 1,
        ];

        $principal_client = $this->getClient(PrincipalClient::class, compact('body'));

        parent::assertArraySubset($body, $principal_client->getPrincipals('endpoint'));
    }

    public function testGetPrincipal()
    {
        $body = [
            'principalName' => 'principal',
            'endpointName'  => 'endpoint',
            'createTime'    => '2017-10-23T07:12:51Z',
        ];

        $principal_client = $this->getClient(PrincipalClient::class, compact('body'));

        parent::assertArraySubset($body, $principal_client->getPrincipal('endpoint', 'principal'));
    }

    public function testSetPrincipal()
    {
        $body = [
            'principalName' => 'principal',
            'endpointName'  => 'endpoint',
            'privateKey'    => '""
              -----BEGIN RSA PRIVATE KEY-----\n
              MIICXQIBAAKBgQC1WUQ5W7RQXReUPyZ3oM9Nz/nTLs9wbebdnM874c+/a6hxxxk6\n
              U98C8vM8gyMI63GxNTBCsuzLbiaMztpramJJ4CPmQJzJyEo65NZFfegCo10kviuj\n
              ph4y4tvEdqdPArVJrXNpZcS10O+3PpHTvv7GUVN50s23Dw7iM9Gny6Y+8wIDAQAB\n
              AoGBAJB/ByAY1IywEEicJM6jBWrvyxSdGMZxm2F7P5hsLbdNVdMKnCxghbJ42Jyf\n
              tLu3tkhHpCORI6JYKzlI3Lp38sWoGI8Nr00mn9FVg8sdTsJDYQ8SwJymsWuQmeXM\n
              5NQiQ4JYz6+wIEUOKyYbbxb2kzTBWoOBHrNDXY7x53WM8TIpAkEA5/kGr6XUJFjt\n
              ubSiIiLM9TlarKX2hw7TQPwKKLpCMsI8P5ydNie1P0Ey9EsHZH9V+SPvpZcz6QEa\n
              yW2NGCEG5wJBAMgh5W7rpAAnDUiFVfQZanqOCtmfDd1Ipvyxr+ND/9mOFry5URyE\n
              vn3xiptExYfthDJUiSoL6pWu20mrqG8KIhUCQESGrBL3SdPy8UcKtVqgLSvD5aVa\n
              4ZjEKGPqEJY3b5bPCj1AZrC4yjIFcKf6AhUOCLewhfrEz/DlAqS+WA/oscECQQCf\n
              DblfFy2m5WJ8MWPndM+YCQ18eRk2tYfpKnqEH0XWLEPLx2g8Rw9x3qZu0hA/ADhh\n
              G6hLX18XiPlEqoVZgm8lAkAIpqajV/6Jy1Mauo0Hjee2jXMNFU7YgcCgHECuka+g\n
              EetA0n12DY2/6B3zdIzE6NBWO64yeY9YH2716WKsQYue\n
              -----END RSA PRIVATE KEY-----\n
              ""',
            'password'     => 'aw3qWSy6l1QgiePN3b7beWOVaGoObiR9ZefT70cKnBA=',
            'createTime'   => '2017-11-08T04:18:57Z',
            'cert'         => '""
              -----BEGIN CERTIFICATE-----\n
              MIIC+jCCAeICCQDlENqPSm8P7DANBgkqhkiG9w0BAQsFADCBgDELMAkGA1UEBhMC\n
              Q04xETAPBgNVBAgTCHNoYW5naGFpMREwDwYDVQQHEwhTaGFuZ2hhaTEOMAwGA1UE\n
              ChMFQmFpZHUxDDAKBgNVBAsTA0JDRTEtMCsGA1UEAxMkYzdhYjllY2EtMmYwNC00\n
              NDQxLTgwZjktMzc1MmM2NmI0MjMyMB4XDTE3MTEwODA0MTg1N1oXDTE3MTEyNTA0\n
              NTkyNlowgYAxCzAJBgNVBAYTAkNOMREwDwYDVQQIEwhzaGFuZ2hhaTERMA8GA1UE\n
              BxMIU2hhbmdoYWkxDjAMBgNVBAoTBUJhaWR1MQwwCgYDVQQLEwNCQ0UxLTArBgNV\n
              BAMTJGM3YWI5ZWNhLTJmMDQtNDQ0MS04MGY5LTM3NTJjNjZiNDIzMjCBnzANBgkq\n
              hkiG9w0BAQEFAAOBjQAwgYkCgYEAtVlEOVu0UF0XlD8mdqDPTc/50y7PcG3m3ZzP\n
              O+HPv2uocccZOlPfAvLzPIMjCOtxsTUwQrLsy24mjM7aa2piSeAj5kCcychKOuTW\n
              RX3oAqNdJL4ro6YeMuLbxHanTwK1Sa1zaWXEtdDvtz6R077+xlFTedLNtw8O4jPR\n
              p8umPvMCAwEAATANBgkqhkiG9w0BAQsFAAOCAQEAb6+pppUQrWOBFqaOTtPkWT2I\n
              KG0K7A3FqtXwF2lquOF+XVbMEOBCjmU00sGeuNYoxf2wA43O0XXAviSnkDIc5MVe\n
              OJXxxQGJ39ituUTnflWx1bDji3DZmbtSncNRHYqnnP46Eu9HolLVf3GBbkRMkvFo\n
              Vwtfe7ZRxI6n3uYd1eesUFcwqUItWpQtMDkL23JyfnKDa8GIfpAgF6Jvgc79PpMF\n
              2f5WGRp/7HAk0DNKz3crNTMneNHlYLROAO5Ei5+oI3df+ihJvxw5H5c8mvHmQmEz\n
              JCaHqGoOVPaI9cCwk33ONtiGuphhmSzHfKDmi6udcG6LdKA54v8o3R9HoOWJ0a==\n
              -----END CERTIFICATE-----\n
              ""',
        ];

        $principal_client = $this->getClient(PrincipalClient::class, ['status' => 201, 'body' => $body]);

        parent::assertArraySubset($body, $principal_client->setPrincipal('endpoint', 'principal'));
    }

    public function testResetPassword()
    {
        $body = [
            'principalName' => 'principal',
            'endpointName'  => 'endpoint',
            'password'     => 'bw3qWSy2l1QgiePN3b7beWOVaGoObiR9ZefT70cKnBB=',
            'privateKey'    => '""
              -----BEGIN RSA PRIVATE KEY-----\n
              MIICXQIBAAKBgQC1WUQ5W7RQXReUPyZ3oM9Nz/nTLs9wbebdnM874c+/a6hxxxk6\n
              U98C8vM8gyMI63GxNTBCsuzLbiaMztpramJJ4CPmQJzJyEo65NZFfegCo10kviuj\n
              ph4y4tvEdqdPArVJrXNpZcS10O+3PpHTvv7GUVN50s23Dw7iM9Gny6Y+8wIDAQAB\n
              AoGBAJB/ByAY1IywEEicJM6jBWrvyxSdGMZxm2F7P5hsLbdNVdMKnCxghbJ42Jyf\n
              tLu3tkhHpCORI6JYKzlI3Lp38sWoGI8Nr00mn9FVg8sdTsJDYQ8SwJymsWuQmeXM\n
              5NQiQ4JYz6+wIEUOKyYbbxb2kzTBWoOBHrNDXY7x53WM8TIpAkEA5/kGr6XUJFjt\n
              ubSiIiLM9TlarKX2hw7TQPwKKLpCMsI8P5ydNie1P0Ey9EsHZH9V+SPvpZcz6QEa\n
              yW2NGCEG5wJBAMgh5W7rpAAnDUiFVfQZanqOCtmfDd1Ipvyxr+ND/9mOFry5URyE\n
              vn3xiptExYfthDJUiSoL6pWu20mrqG8KIhUCQESGrBL3SdPy8UcKtVqgLSvD5aVa\n
              4ZjEKGPqEJY3b5bPCj1AZrC4yjIFcKf6AhUOCLewhfrEz/DlAqS+WA/oscECQQCf\n
              DblfFy2m5WJ8MWPndM+YCQ18eRk2tYfpKnqEH0XWLEPLx2g8Rw9x3qZu0hA/ADhh\n
              G6hLX18XiPlEqoVZgm8lAkAIpqajV/6Jy1Mauo0Hjee2jXMNFU7YgcCgHECuka+g\n
              EetA0n12DY2/6B3zdIzE6NBWO64yeY9YH2716WKsQYue\n
              -----END RSA PRIVATE KEY-----\n
              ""',
            'cert'         => '""
              -----BEGIN CERTIFICATE-----\n
              MIIC+jCCAeICCQDlENqPSm8P7DANBgkqhkiG9w0BAQsFADCBgDELMAkGA1UEBhMC\n
              Q04xETAPBgNVBAgTCHNoYW5naGFpMREwDwYDVQQHEwhTaGFuZ2hhaTEOMAwGA1UE\n
              ChMFQmFpZHUxDDAKBgNVBAsTA0JDRTEtMCsGA1UEAxMkYzdhYjllY2EtMmYwNC00\n
              NDQxLTgwZjktMzc1MmM2NmI0MjMyMB4XDTE3MTEwODA0MTg1N1oXDTE3MTEyNTA0\n
              NTkyNlowgYAxCzAJBgNVBAYTAkNOMREwDwYDVQQIEwhzaGFuZ2hhaTERMA8GA1UE\n
              BxMIU2hhbmdoYWkxDjAMBgNVBAoTBUJhaWR1MQwwCgYDVQQLEwNCQ0UxLTArBgNV\n
              BAMTJGM3YWI5ZWNhLTJmMDQtNDQ0MS04MGY5LTM3NTJjNjZiNDIzMjCBnzANBgkq\n
              hkiG9w0BAQEFAAOBjQAwgYkCgYEAtVlEOVu0UF0XlD8mdqDPTc/50y7PcG3m3ZzP\n
              O+HPv2uocccZOlPfAvLzPIMjCOtxsTUwQrLsy24mjM7aa2piSeAj5kCcychKOuTW\n
              RX3oAqNdJL4ro6YeMuLbxHanTwK1Sa1zaWXEtdDvtz6R077+xlFTedLNtw8O4jPR\n
              p8umPvMCAwEAATANBgkqhkiG9w0BAQsFAAOCAQEAb6+pppUQrWOBFqaOTtPkWT2I\n
              KG0K7A3FqtXwF2lquOF+XVbMEOBCjmU00sGeuNYoxf2wA43O0XXAviSnkDIc5MVe\n
              OJXxxQGJ39ituUTnflWx1bDji3DZmbtSncNRHYqnnP46Eu9HolLVf3GBbkRMkvFo\n
              Vwtfe7ZRxI6n3uYd1eesUFcwqUItWpQtMDkL23JyfnKDa8GIfpAgF6Jvgc79PpMF\n
              2f5WGRp/7HAk0DNKz3crNTMneNHlYLROAO5Ei5+oI3df+ihJvxw5H5c8mvHmQmEz\n
              JCaHqGoOVPaI9cCwk33ONtiGuphhmSzHfKDmi6udcG6LdKA54v8o3R9HoOWJ0a==\n
              -----END CERTIFICATE-----\n
              ""',
        ];

        $principal_client = $this->getClient(PrincipalClient::class, compact('body'));

        parent::assertArraySubset($body, $principal_client->resetPassword('endpoint', 'principal'));
    }

    public function testUnsetPrincipal()
    {
        $principal_client = $this->getClient(PrincipalClient::class, ['status' => 204]);

        parent::assertNull($principal_client->unsetPrincipal('endpoint', 'principal'));
    }
}
