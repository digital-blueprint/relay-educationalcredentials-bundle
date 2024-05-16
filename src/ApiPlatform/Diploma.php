<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\ApiPlatform;

use Symfony\Component\Serializer\Annotation\Groups;

class Diploma
{
    private $identifier;

    /**
     * @var string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
    private $name;

    /**
     * @var string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
    private $credentialCategory;

    /**
     * @var string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
    private $educationalLevel;

    /**
     * @var string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
    private $creator;

    /**
     * @var string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
    private $validFrom;

    /**
     * @var string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
    private $educationalAlignment;

    /**
     * @var ?string
     */
    #[Groups(['EducationalcredentialsDiploma:output', 'EducationalcredentialsDiploma:input'])]
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
