<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Controller;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LoggedInOnly extends AbstractController
{
    public function __invoke(Diploma $data, Request $request): Diploma
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $data;
    }
}
