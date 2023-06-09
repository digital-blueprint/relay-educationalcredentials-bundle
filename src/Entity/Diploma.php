<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Dbp\Relay\EducationalcredentialsBundle\Controller\CreateEducationalCredentialAction;
use Dbp\Relay\EducationalcredentialsBundle\Controller\CreateLocalEducationalCredentialAction;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get" = {
 *             "security" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *             "path" = "/educationalcredentials/diplomas",
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *                 "summary" = "Get all available diploma from local data.",
 *             },
 *         },
 *         "post" = {
 *             "security" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *             "path" = "/educationalcredentials/diplomas",
 *             "method" = "POST",
 *             "controller" = CreateEducationalCredentialAction::class,
 *             "deserialize" = false,
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *                 "summary" = "Create a diploma from remote data (VC).",
 *                 "requestBody" = {
 *                     "content" = {
 *                         "multipart/form-data" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {
 *                                     "text" = {"description" = "VC supplied by student", "type" = "string", "example" = ""},
 *                                 },
 *                                 "required" = {"text"},
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         }
 *     },
 *     itemOperations={
 *         "get" = {
 *             "security" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *             "path" = "/educationalcredentials/diplomas/{identifier}",
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *                 "summary" = "Get a diploma from local data.",
 *                 "parameters" = {
 *                     {"name" = "identifier", "in" = "path", "description" = "Id of diploma", "required" = true, "type" = "string", "example" = "0a9f591d-e553-4a4d-a958-e86ce0269d08"},
 *                 }
 *             },
 *         },
 *         "post_create_vc" = {
 *             "security" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *             "method" = "POST",
 *             "path" = "/educationalcredentials/diplomas/{identifier}/verifiable",
 *             "controller" = CreateLocalEducationalCredentialAction::class,
 *             "openapi_context" = {
 *                 "tags" = {"Educational Credentials"},
 *                 "summary" = "Create a Educational Credential from local data.",
 *                 "requestBody" = {
 *                     "content" = {
 *                         "application/json" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {
 *                                     "did" = {"description" = "DID supplied by student", "type" = "string", "example" = "did:key:z6MkqyYXcBQZ5hZ9BFHBiVnmrZ1C1HCpesgZQoTdgjLdU6Ah"},
 *                                     "format" = {"description" = "jsonldjwt or empty", "type" = "string", "example" = "jsonldjwt"},
 *                                 },
 *                                 "required" = {"did"},
 *                             },
 *                         }
 *                     }
 *                 },
 *                 "parameters" = {
 *                     {"name" = "identifier", "in" = "path", "description" = "Id of diploma", "required" = true, "type" = "string", "example" = "0a9f591d-e553-4a4d-a958-e86ce0269d08"},
 *                 }
 *             },
 *         },
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
     * @var ?string
     */
    private $text = '';

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }
}
