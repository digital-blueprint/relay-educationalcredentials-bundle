<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Dbp\Relay\EducationalcredentialsBundle\Controller\LoggedInOnly;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get" = {
 *             "path" = "/educationalcredentials/diplomas",
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *             },
 *         }
 *     },
 *     itemOperations={
 *         "get" = {
 *             "path" = "/educationalcredentials/diplomas/{identifier}",
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *             },
 *         },
 *         "put" = {
 *             "path" = "/educationalcredentials/diplomas/{identifier}",
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *             },
 *         },
 *         "delete" = {
 *             "path" = "/educationalcredentials/diplomas/{identifier}",
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *             },
 *         },
 *         "loggedin_only" = {
 *             "security" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *             "method" = "GET",
 *             "path" = "/educationalcredentials/diplomas/{identifier}/loggedin-only",
 *             "controller" = LoggedInOnly::class,
 *             "openapi_context" = {
 *                 "summary" = "Only works when logged in.",
 *                 "tags" = {"Educational Credentials"},
 *             },
 *         }
 *     },
 *     iri="https://schema.org/Diploma",
 *     shortName="EducationalcredentialsDiploma",
 *     normalizationContext={
 *         "groups" = {"EducationalcredentialsDiploma:output"},
 *         "jsonld_embed_context" = true
 *     },
 *     denormalizationContext={
 *         "groups" = {"EducationalcredentialsDiploma:input"},
 *         "jsonld_embed_context" = true
 *     }
 * )
 */
class Diploma
{
    /**
     * @ApiProperty(identifier=true)
     */
    private $identifier;

    /**
     * @ApiProperty(iri="https://schema.org/name")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }
}
