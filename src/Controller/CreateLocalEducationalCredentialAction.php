<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Controller;

use Dbp\Relay\CoreBundle\Exception\ApiError;
use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use Dbp\Relay\EducationalcredentialsBundle\Service\DiplomaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function __invoke(string $identifier, Request $request): Diploma
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $body = json_decode($request->getContent(), false, 32);
        $did = $body->did;
        $format = $body->format ?? '';
        //dump("got did = '$did'");
        $diploma = $this->api->getDiplomaById($identifier);
        if ($diploma === null) {
            throw new ApiError(Response::HTTP_BAD_REQUEST, 'requested diploma id unknown');
        }
        $vc = $this->api->getVerifiableCredential($diploma, $did, $format);
        if (!$vc) {
            throw new ApiError(Response::HTTP_BAD_REQUEST, 'unable to create verifiable crendential');
        }
        $diploma->setText($vc);

        return $diploma;
    }
}
