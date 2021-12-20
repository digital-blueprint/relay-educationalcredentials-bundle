<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;

class ExternalApi implements DiplomaProviderInterface
{
    private $diplomas;
    private $service;

    public function __construct(ConfigService $service)
    {
        // Make phpstan happy
        $this->service = $service;

        $this->diplomas = [];
        $diploma1 = new Diploma();
        $diploma1->setIdentifier('0a9f591d-e553-4a4d-a958-e86ce0269d08');
        $diploma1->setName('Master Studies in Computer Science');
        $diploma1->setCredentialCategory('degree');
        $diploma1->setEducationalLevel('Master of Science');
        $diploma1->setCreator('TU Graz');
        $diploma1->setValidFrom('2021-03-18T00:00:00.000Z');
        $diploma1->setEducationalAlignment('ISCED/481');
        $diploma1->setText('');

        $diploma2 = new Diploma();
        $diploma2->setIdentifier('8d619927-28b7-4970-9e5a-c4a47d8e9ad1');
        $diploma2->setName('Bachelor Studies in Computer Science');
        $diploma2->setCredentialCategory('degree');
        $diploma2->setEducationalLevel('Bachelor');
        $diploma2->setCreator('TU Graz');
        $diploma2->setValidFrom('2029-09-04T00:00:00.000Z');
        $diploma2->setEducationalAlignment('ISCED/480');
        $diploma2->setText('');

        $this->diplomas[] = $diploma1;
        $this->diplomas[] = $diploma2;
    }

    public function getDiplomaById(string $identifier): ?Diploma
    {
        foreach ($this->diplomas as &$diploma) {
            if ($diploma->getIdentifier() === $identifier) {
                return $diploma;
            }
        }

        return null;
    }

    public function getDiplomas(): array
    {
        return $this->diplomas;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVerifiableCredential(Diploma $diploma, string $did): string
    {
        $user = new \stdClass();
        $user->fistname = 'Eva';
        $user->lastname = 'Musterfrau';
        $user->dateOfBirth = '1999-10-22T00:00:00.000Z';
        $user->immatriculationNumber = '0000000';
        /*
        {
            "credential": {
                "@context": [
                    "https://www.w3.org/2018/credentials/v1",
                    "https://danubetech.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v1.jsonld",
                ],
                "type": [
                    "VerifiableCredential",
                    "VerifiableAttestation",
                    "DiplomaCredential"
                ],
                "issuer":"did:ebsi:z23EQVGi5so9sBwytv6nMXMo",
                "issuanceDate":"2021-12-07T14:48:12Z",
                "credentialSubject": {
                    "type":"Student",
                    "id":"did:ebsi:zqpZej3RbScW9feAjwipKn4",
                    "studyProgram":"Master Studies in Strategy, Innovation, and Management Control",
                    "immatriculationNumber":"00000000",
                    "currentGivenName":"Eva",
                    "currentFamilyName":"Musterfrau",
                    "learningAchievement":"Master's Degree",
                    "dateOfBirth":"1999-10-22T00:00:00.000Z",
                    "dateOfAchievement":"2021-01-04T00:00:00.000Z",
                    "overallEvaluation":"passed with honors",
                    "eqfLevel":"http://data.europa.eu/snb/eqf/7",
                    "targetFrameworkName":"European Qualifications Framework for lifelong learning - (2008/C 111/01)"},
                    "proof": {
                        "type":"EcdsaSecp256k1Signature2019",
                        "created":"2021-12-07T14:48:12Z",
                        "proofPurpose":"assertionMethod",
                        "verificationMethod":"did:ebsi:z23EQVGi5so9sBwytv6nMXMo#keys-1",
                        "jws":"eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..RDoJ76LMvKNzPiIEdlFF41DzU_mbY_juQEyGX-NgZe4Q2Cf5AT9wztvr4qk8CNZxc5FxN3v0_Gcqvjtm5hnDNw"
                    }
            },
            "options": {"format": "jsonldjwt"}
        }
        */
        $obj = new \stdClass();
        $obj->credential = new \stdClass();
        $obj->credential->{'@context'} = [
            'https://www.w3.org/2018/credentials/v1',
            'https://danubetech.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v1.jsonld',
        ];
        $obj->credential->type = [
            'VerifiableCredential',
            'VerifiableAttestation',
            'DiplomaCredential',
        ];
        $obj->credential->issuer = $this->service->issuer;
        $obj->credential->issuanceDate = date('Y-m-d\TH:i:s\Z', time() - 3600); //server need to be set to UTC
        $obj->credential->credentialSubject = new \stdClass();
        $obj->credential->credentialSubject->type = 'Student';
        $obj->credential->credentialSubject->id = $did;
        $obj->credential->credentialSubject->studyProgram = $diploma->getName();
        $obj->credential->credentialSubject->learningAchievement = $diploma->getEducationalLevel();
        $obj->credential->credentialSubject->dateOfAchievement = $diploma->getValidFrom();
        $obj->credential->credentialSubject->immatriculationNumber = $user->immatriculationNumber;
        $obj->credential->credentialSubject->currentGivenName = $user->fistname;
        $obj->credential->credentialSubject->currentFamilyName = $user->lastname;
        $obj->credential->credentialSubject->dateOfBirth = $user->dateOfBirth;
        $obj->credential->credentialSubject->overallEvaluation = 'passed with honors';
        $obj->credential->credentialSubject->eqfLevel = 'http://data.europa.eu/snb/eqf/7'; //$diploma->getEducationalAlignment(); // "ISCED/433";
        $obj->credential->credentialSubject->targetFrameworkName = 'European Qualifications Framework for lifelong learning - (2008/C 111/01)';

        $obj->options = new \stdClass();
        $obj->options->format = 'jsonldjwt';

        $stack = HandlerStack::create();
        $client_options = [
            'handler' => $stack,
        ];
//        if ($this->logger !== null) {
//            $stack->push(Tools::createLoggerMiddleware($this->logger));
//        }
        $client = new Client($client_options);

        try {
            $response = $client->post($this->service->urlIssuer, [
                RequestOptions::JSON => $obj,
            ]);
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
        }

        return $response->getBody()->getContents();
    }
}
