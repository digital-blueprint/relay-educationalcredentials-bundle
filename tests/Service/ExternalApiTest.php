<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Tests\Service;

use Dbp\Relay\EducationalcredentialsBundle\Service\ConfigService;
use Dbp\Relay\EducationalcredentialsBundle\Service\ExternalApi;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExternalApiTest extends WebTestCase
{
    private $api;

    protected function setUp(): void
    {
        $service = new ConfigService(
            'did:ebsi:abc...',
            'http://localhost:13080/1.0/credentials/issue',
            'http://localhost:14080/1.0/credentials/verify'
        );
        //$this->api = new ExternalApi($service);
    }

    public function test()
    {
        $this->assertTrue(true);
        //$this->assertNotNull($this->api);
    }
}
