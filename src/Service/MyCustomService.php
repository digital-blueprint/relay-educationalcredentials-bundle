<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

class ConfigService
{
    private $issuer;

    public function __construct(string $issuer)
    {
        $this->issuer = $issuer;
    }
}
