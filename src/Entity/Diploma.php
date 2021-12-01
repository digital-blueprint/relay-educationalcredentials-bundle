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
 *     iri="https://schema.org/EducationalOccupationalCredential",
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

    /**
     * @ApiProperty(iri="https://schema.org/credentialCategory")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $credentialCategory;

    /**
     * @ApiProperty(iri="https://schema.org/educationalLevel")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $educationalLevel;

    /**
     * @ApiProperty(iri="https://schema.org/creator")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $creator;

    /**
     * @ApiProperty(iri="https://schema.org/validFrom")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $validFrom;

    /**
     * @ApiProperty(iri="https://schema.org/educationalAlignment")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $educationalAlignment;

    /**
     * @ApiProperty(iri="https://schema.org/text")
     * @Groups({"EducationalcredentialsDiploma:output", "EducationalcredentialsDiploma:input"})
     *
     * @var string
     */
    private $text = "";


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

    public function getCredentialCategory(): string
    {
        return $this->credentialCategory;
    }

    public function setCredentialCategory(string $credentialCategory): void
    {
        $this->credentialCategory = $credentialCategory;
    }

    public function getEducationalLevel(): string
    {
        return $this->educationalLevel;
    }

    public function setEducationalLevel(string $educationalLevel): void
    {
        $this->educationalLevel = $educationalLevel;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): void
    {
        $this->creator = $creator;
    }

    public function getValidFrom(): string
    {
        return $this->validFrom;
    }

    public function setValidFrom(string $validFrom): void
    {
        $this->validFrom = $validFrom;
    }

    public function getEducationalAlignment(): string
    {
        return $this->educationalAlignment;
    }

    public function setEducationalAlignment(string $educationalAlignment): void
    {
        $this->educationalAlignment = $educationalAlignment;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
