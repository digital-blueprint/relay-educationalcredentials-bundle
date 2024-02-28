<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\ApiPlatform;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use ApiPlatform\State\ProviderInterface;
use Dbp\Relay\CoreBundle\Rest\Query\Pagination\PartialPaginator;
use Dbp\Relay\EducationalcredentialsBundle\Service\DiplomaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @implements ProviderInterface<Diploma>
 */
final class DiplomaProvider extends AbstractController implements ProviderInterface
{
    private $api;

    public function __construct(DiplomaProviderInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @return PartialPaginatorInterface<object>|iterable<mixed, object>|object|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation instanceof CollectionOperationInterface) {
            $perPage = 30;
            $page = 1;

            $filters = $context['filters'] ?? [];
            if (isset($filters['page'])) {
                $page = (int) $filters['page'];
            }
            if (isset($filters['perPage'])) {
                $perPage = (int) $filters['perPage'];
            }

            return new PartialPaginator($this->api->getDiplomas(), $page, $perPage);
        } else {
            $id = $uriVariables['identifier'];
            assert(is_string($id));

            return $this->api->getDiplomaById($id);
        }
    }
}
