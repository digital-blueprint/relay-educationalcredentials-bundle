<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;

class ExternalApi implements DiplomaProviderInterface
{
    private $diplomas;

    public function __construct(ConfigService $service)
    {
        // Make phpstan happy
        $service = $service;

        $this->diplomas = [];
        $diploma1 = new Diploma();
        $diploma1->setIdentifier('graz');
        $diploma1->setName('Graz');

        $diploma2 = new Diploma();
        $diploma2->setIdentifier('vienna');
        $diploma2->setName('Vienna');

        $this->diplomas[] = $diploma1;
        $this->diplomas[] = $diploma2;
    }

    public function getDiplomaById(string $identifier): ?Diploma
    {
        foreach ($this->diplomas as $diploma) {
            if ($diploma->getIdentifier() === $identifier) {
                return $diploma;
            }
        }

        return null;
    }

    public function getDiplomas(): array
    {
        return $this->diplomas;
    }
}
