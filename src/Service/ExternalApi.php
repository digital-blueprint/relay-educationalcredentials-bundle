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
     * @param Diploma $diploma
     * @param string $did
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVerifiableCredential(Diploma $diploma, string $did): string
    {
        /*
         {
            "credential": {
                "@context": [
                    "https://www.w3.org/2018/credentials/v1",
                    "https://essif.europa.eu/schemas/vc/2020/v1"
                ],
                "type": [
                    "VerifiableCredential",
                    "VerifiableAttestation",
                    "DiplomaCredential"
                ],
                "issuer": "did:ebsi:zuoS6VfnmNLduF2dynhsjBU",
                "credentialSubject": {
                    "type": "Student",
                    "id": "did:key:z6MkqyYXcBQZ5hZ9BFHBiVnmrZ1C1HCpesgZQoTdgjLdU6Ah",
                    "studyProgram": "Master Studies in Computer Science",
                    "learningAchievement": "Master of Science",
                    "dateOfAchievement": "2021-03-18T00:00:00.000Z",
                    "eqfLevel": "http://data.europa.eu/snb/eqf/7",
                    "targetFrameworkName": "European Qualifications Framework for lifelong learning - (2008/C 111/01)"
                }
            },
            "options": {"format": "jsonldjwt"}
         }
         */
        $obj = new \stdClass();
        $obj->credential = new \stdClass();
        $obj->credential->{'@context'} = [
            'https://www.w3.org/2018/credentials/v1',
            'https://essif.europa.eu/schemas/vc/2020/v1',
        ];
        $obj->credential->type = [
            'VerifiableCredential',
            'VerifiableAttestation',
            'DiplomaCredential',
        ];
        $obj->credential->issuer = $this->service->issuer;
        $obj->credential->credentialSubject = new \stdClass();
        $obj->credential->credentialSubject->type = 'Student';
        $obj->credential->credentialSubject->id = $did;
        $obj->credential->credentialSubject->studyProgram = $diploma->getName();
        $obj->credential->credentialSubject->learningAchievement = 'Master of Science';
        $obj->credential->credentialSubject->dateOfAchievement = $diploma->getValidFrom();
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
