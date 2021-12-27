<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\Service;

use Dbp\Relay\BasePersonBundle\API\PersonProviderInterface;
use Dbp\Relay\CoreBundle\Helpers\GuzzleTools;
use Dbp\Relay\EducationalcredentialsBundle\Entity\Diploma;
use GuzzleHttp\Client;
//use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerAwareTrait;

class ExternalApi implements DiplomaProviderInterface
{
    use LoggerAwareTrait;

    private $diplomas;
    private $service;
    private $personProvider;

    public function __construct(ConfigService $service, PersonProviderInterface $personProvider)
    {
        $this->service = $service;
        $this->personProvider = $personProvider;

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
        $diploma2->setValidFrom('2019-09-04T00:00:00.000Z');
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
        $person = $this->personProvider->getCurrentPerson();

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
        $obj->credential->credentialSubject->immatriculationNumber = '0000000';
        $obj->credential->credentialSubject->currentGivenName = $person->getGivenName();
        $obj->credential->credentialSubject->currentFamilyName = $person->getFamilyName();
        $obj->credential->credentialSubject->dateOfBirth = date('Y-m-d\TH:i:s\Z', strtotime($person->getBirthDate()));
        $obj->credential->credentialSubject->overallEvaluation = 'passed with honors';
        $obj->credential->credentialSubject->eqfLevel = 'http://data.europa.eu/snb/eqf/7'; //$diploma->getEducationalAlignment(); // "ISCED/433";
        $obj->credential->credentialSubject->targetFrameworkName = 'European Qualifications Framework for lifelong learning - (2008/C 111/01)';

        $obj->options = new \stdClass();
        $obj->options->format = 'jsonldjwt';

        $stack = HandlerStack::create();
        $client_options = [
            'handler' => $stack,
        ];
        if ($this->logger !== null) {
            $stack->push(GuzzleTools::createLoggerMiddleware($this->logger));
        }
        $client = new Client($client_options);

        try {
            $response = $client->post(
                $this->service->urlIssuer,
                [RequestOptions::JSON => $obj]
            );
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
//        } catch (GuzzleException $e) {
        }

        return $response->getBody()->getContents();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function verifyVerifiableCredential($text): ?Diploma
    {
        $person = $this->personProvider->getCurrentPerson();

        /*
        {
            "verifiableCredential": {
                "vc": "eyJraWQiOiJkaWQ6ZWJzaTp6dW9TNlZmbm1OTGR1RjJkeW5oc2pCVSNrZXlzLTEiLCJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NksifQ.eyJzdWIiOiJkaWQ6a2V5Ono2TWtxeVlYY0JRWjVoWjlCRkhCaVZubXJaMUMxSENwZXNnWlFvVGRnakxkVTZBaCIsIm5iZiI6MTYzOTk4NzczNywiaXNzIjoiZGlkOmVic2k6enVvUzZWZm5tTkxkdUYyZHluaHNqQlUiLCJ2YyI6eyJAY29udGV4dCI6WyJodHRwczovL3d3dy53My5vcmcvMjAxOC9jcmVkZW50aWFscy92MSIsImh0dHBzOi8vZGFudWJldGVjaC5naXRodWIuaW8vZWJzaTRhdXN0cmlhLWV4YW1wbGVzL2NvbnRleHQvZXNzaWYtc2NoZW1hcy12Yy0yMDIwLXYxLmpzb25sZCJdLCJ0eXBlIjpbIlZlcmlmaWFibGVDcmVkZW50aWFsIiwiVmVyaWZpYWJsZUF0dGVzdGF0aW9uIiwiRGlwbG9tYUNyZWRlbnRpYWwiXSwiY3JlZGVudGlhbFN1YmplY3QiOnsidHlwZSI6IlN0dWRlbnQiLCJzdHVkeVByb2dyYW0iOiJNYXN0ZXIgU3R1ZGllcyBpbiBDb21wdXRlciBTY2llbmNlIiwibGVhcm5pbmdBY2hpZXZlbWVudCI6Ik1hc3RlciBvZiBTY2llbmNlIiwiZGF0ZU9mQWNoaWV2ZW1lbnQiOiIyMDIxLTAzLTE4VDAwOjAwOjAwLjAwMFoiLCJpbW1hdHJpY3VsYXRpb25OdW1iZXIiOiIwMDAwMDAwIiwiY3VycmVudEdpdmVuTmFtZSI6IkV2YSIsImN1cnJlbnRGYW1pbHlOYW1lIjoiTXVzdGVyZnJhdSIsImRhdGVPZkJpcnRoIjoiMTk5OS0xMC0yMlQwMDowMDowMC4wMDBaIiwib3ZlcmFsbEV2YWx1YXRpb24iOiJwYXNzZWQgd2l0aCBob25vcnMiLCJlcWZMZXZlbCI6Imh0dHA6Ly9kYXRhLmV1cm9wYS5ldS9zbmIvZXFmLzciLCJ0YXJnZXRGcmFtZXdvcmtOYW1lIjoiRXVyb3BlYW4gUXVhbGlmaWNhdGlvbnMgRnJhbWV3b3JrIGZvciBsaWZlbG9uZyBsZWFybmluZyAtICgyMDA4L0MgMTExLzAxKSJ9fX0.TkhjBahkm2azVYkgJ2Lk998oUZBYvdk8rziogBNc4M9NTp9c9yq77DBRb3PIqsTYL-ukKRsD3fK40b1Q9ukVJg"
            },
            "options": {
                    "returnMetadata": true   // not jet in W3C standard :-(
            }
        }
        */
        $obj = new \stdClass();
        $obj->verifiableCredential = new \stdClass();
        $obj->verifiableCredential->vc = $text;
        $obj->options = new \stdClass();
        $obj->options->returnMetadata = true;

        $stack = HandlerStack::create();
        $client_options = [
            'handler' => $stack,
        ];
        if ($this->logger !== null) {
            $stack->push(GuzzleTools::createLoggerMiddleware($this->logger));
        }

        $client = new Client($client_options);

        try {
            $response = $client->post(
                $this->service->urlVerifier,
                [RequestOptions::JSON => $obj]
            );
            $result = json_decode(
                $response->getBody()->getContents(),
                false,
                32,
                JSON_THROW_ON_ERROR
            );
            dump($result); // TODO remove
            $ok = $result->verified;
        } catch (RequestException $e) {
            //$message = $e->getMessage();
            if ($e->getCode() === 400) {
                $ok = false;
            } else {
                throw $e;
            }
//        } catch (GuzzleException $e) {
        }

        if ($ok) {
            $json = json_decode(
                base64_decode(str_replace(['_', '-'], ['/', '+'], explode('.', $text)[1]), true),
                false,
                512,
                JSON_THROW_ON_ERROR
            );
            dump($json); // TODO remove

            if ($json->vc->credentialSubject->currentGivenName !== $person->getGivenName()
               || $json->vc->credentialSubject->currentFamilyName !== $person->getFamilyName()
               || $json->vc->credentialSubject->dateOfBirth !== date('Y-m-d\TH:i:s\Z', strtotime($person->getBirthDate()))) {
                // names and/or birthday do not match - no automatic verification
                return null;
            }

            /*
            {
              "sub": "did:key:z6MkqyYXcBQZ5hZ9BFHBiVnmrZ1C1HCpesgZQoTdgjLdU6Ah",
              "nbf": 1639987737,
              "iss": "did:ebsi:zuoS6VfnmNLduF2dynhsjBU",
              "vc": {
                "@context": [
                  "https://www.w3.org/2018/credentials/v1",
                  "https://danubetech.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v1.jsonld"
                ],
                "type": [
                  "VerifiableCredential",
                  "VerifiableAttestation",
                  "DiplomaCredential"
                ],
                "credentialSubject": {
                  "type": "Student",
                  "studyProgram": "Master Studies in Computer Science",
                  "learningAchievement": "Master of Science",
                  "dateOfAchievement": "2021-03-18T00:00:00.000Z",
                  "immatriculationNumber": "0000000",
                  "currentGivenName": "Eva",
                  "currentFamilyName": "Musterfrau",
                  "dateOfBirth": "1999-10-22T00:00:00.000Z",
                  "overallEvaluation": "passed with honors",
                  "eqfLevel": "http://data.europa.eu/snb/eqf/7",
                  "targetFrameworkName": "European Qualifications Framework for lifelong learning - (2008/C 111/01)"
                }
              }
            }
            */
            if (strpos($json->vc->credentialSubject->learningAchievement, 'Master') !== false) {
                $learningAchievement = 'Master';
            } elseif (strpos($json->vc->credentialSubject->learningAchievement, 'Bachelor') !== false) {
                $learningAchievement = 'Bachelor';
            } else {
                $learningAchievement = 'unknown';
            }

            $diploma = new Diploma();
            $diploma->setIdentifier(uniqid('', true));
            $diploma->setName($json->vc->credentialSubject->studyProgram);
            $diploma->setCredentialCategory('degree');
            $diploma->setEducationalLevel($learningAchievement);
            $diploma->setCreator($json->iss);
            $diploma->setValidFrom($json->vc->credentialSubject->dateOfAchievement);
            $diploma->setEducationalAlignment('ISCED/480');
            $diploma->setText($text);
        } else {
            $diploma = null;
        }

        return $diploma;
    }
}
