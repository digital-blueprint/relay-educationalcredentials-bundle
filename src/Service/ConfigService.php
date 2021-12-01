<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

class ConfigService
{
    public $issuer;
    public $urlIssuer;
    private $urlVerifier;

    public function __construct(string $issuer, string $urlIssuer, string $urlVerifier)
    {
        $this->issuer = $issuer;
        $this->urlIssuer = $urlIssuer;
        $this->urlVerifier = $urlVerifier;
    }
}
