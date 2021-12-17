<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Controller;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use Dbp\Relay\EducationalcredentialsBundle\Service\DiplomaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class CreateEducationalCredentialAction extends AbstractController
{
    protected $api;

    public function __construct(DiplomaProviderInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @throws HttpException
     */
    public function __invoke(Request $request): ?Diploma
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $id = $request->get('id', '');
        $did = $request->get('did', '');

        $diploma = $this->api->getDiplomaById($id);
        if ($diploma !== null) {
            $vc = $this->api->getVerifiableCredential($diploma, $did);
            $diploma->setText($vc ?? 'N/A');
        }

        return $diploma;
    }
}
