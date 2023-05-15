<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use Dbp\Relay\EducationalcredentialsBundle\Service\DiplomaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiplomaDataPersister extends AbstractController implements DataPersisterInterface
{
    private $api;

    public function __construct(DiplomaProviderInterface $api)
    {
        $this->api = $api;
    }

    public function supports($data): bool
    {
        return $data instanceof Diploma;
    }

    public function persist($data): void
    {
        // TODO
    }

    public function remove($data)
    {
        // TODO
    }
}
