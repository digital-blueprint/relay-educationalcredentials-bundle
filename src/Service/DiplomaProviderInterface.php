<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;

interface DiplomaProviderInterface
{
    public function getDiplomaById(string $identifier): ?Diploma;

    public function getDiplomas(): array;
}
