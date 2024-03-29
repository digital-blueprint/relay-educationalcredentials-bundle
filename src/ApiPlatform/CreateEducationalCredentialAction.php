<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\ApiPlatform;

use Dbp\Relay\CoreBundle\Exception\ApiError;
use Dbp\Relay\EducationalcredentialsBundle\Service\DiplomaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
    public function __invoke(Request $request): Diploma
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $text = $request->get('text');
        if ($text === null) {
            throw new BadRequestHttpException('Missing "text"');
        }

        $diploma = $this->api->verifyVerifiableCredential($text);
        if ($diploma === null) {
            throw new ApiError(Response::HTTP_BAD_REQUEST, 'unable to verify given credential');
        }

        return $diploma;
    }
}
