<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use Psr\Log\LoggerAwareInterface;

interface DiplomaProviderInterface extends LoggerAwareInterface
{
    public function getDiplomaById(string $identifier): ?Diploma;

    public function getDiplomas(): array;

    public function getVerifiableCredential(Diploma $diploma, string $did): string;

    public function verifyVerifiableCredential($text): ?Diploma;
}
