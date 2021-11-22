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
        $service = new ConfigService('secret-test-custom');
        $this->api = new ExternalApi($service);
    }

    public function test()
    {
        $this->assertTrue(true);
        $this->assertNotNull($this->api);
    }
}
