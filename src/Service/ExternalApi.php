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
        $diploma1->setIdentifier('0a9f591d-e553-4a4d-a958-e86ce0269d08');
        $diploma1->setName('Master Studies in Computer Science');
        $diploma1->setCredentialCategory('degree');
        $diploma1->setEducationalLevel('Master of Science');
        $diploma1->setCreator('TU Graz');
        $diploma1->setValidFrom('2021-03-18T00:00:00.000Z');
        $diploma1->setEducationalAlignment('ISCED/481');

        $diploma2 = new Diploma();
        $diploma2->setIdentifier('8d619927-28b7-4970-9e5a-c4a47d8e9ad1');
        $diploma2->setName('Bachelor Studies in Computer Science');
        $diploma1->setCredentialCategory('degree');
        $diploma1->setEducationalLevel('Bachelor');
        $diploma1->setCreator('TU Graz');
        $diploma1->setValidFrom('2029-09-04T00:00:00.000Z');
        $diploma1->setEducationalAlignment('ISCED/480');

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
