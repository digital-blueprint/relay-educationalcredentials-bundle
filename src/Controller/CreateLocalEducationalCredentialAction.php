<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Controller;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use Dbp\Relay\EducationalcredentialsBundle\Service\DiplomaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class CreateLocalEducationalCredentialAction extends AbstractController
{
    protected $api;

    public function __construct(DiplomaProviderInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @throws HttpException
     */
    public function __invoke(string $identifier, Request $request): ?Diploma
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $did = $request->get('did', '');

        $diploma = $this->api->getDiplomaById($identifier);
        if ($diploma !== null) {
            $vc = $this->api->getVerifiableCredential($diploma, $did);
            $diploma->setText($vc ?? 'N/A');
        }

        return $diploma;
    }
}
