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
        $diploma1->setEducationalLevel('Master\'s Degree');
        $diploma1->setCreator('TU Graz');
        $diploma1->setValidFrom('2021-03-18T00:00:00.000Z');
        $diploma1->setEducationalAlignment('481');
        $diploma1->setText('');

        $diploma2 = new Diploma();
        $diploma2->setIdentifier('8d619927-28b7-4970-9e5a-c4a47d8e9ad1');
        $diploma2->setName('Bachelor Studies in Computer Science');
        $diploma2->setCredentialCategory('degree');
        $diploma2->setEducationalLevel('Bachelor\'s Degree');
        $diploma2->setCreator('TU Graz');
        $diploma2->setValidFrom('2019-09-04T00:00:00.000Z');
        $diploma2->setEducationalAlignment('480');
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
    public function getVerifiableCredential(Diploma $diploma, string $did, string $format = ''): string
    {
        // This is fake because we must not use DanubeTech's docker anymore
        $result = '';
        switch ($diploma->getIdentifier()) {
            case '8d619927-28b7-4970-9e5a-c4a47d8e9ad1':
                $result = <<< EOT
{"@context":["https://www.w3.org/2018/credentials/v1","https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld"],"type":["VerifiableCredential","VerifiableAttestation","DiplomaCredential"],"id":"urn:uuid:03c1534f-8513-45f2-bd5b-dde0f1a20dfd","name":"Bachelor Studies in Computer Science, 2019-09-04","description":"Diploma of TU Graz","image":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAABcGlDQ1BpY2MAACiRdZG9S8NAGMaftmqLVjroIOKQoYpDK0VBHLUOXYqUWsGqS3JNWiFJwyVFiqvg4lBwEF38GvwPdBVcFQRBEURc/Af8WqTE95pCi7R3XN4fT+55uXsO8Kd1Ztg9CcAwHZ5NJaXV/JoUfEeQZghT6JOZbS1kMml0HT+P8In6EBe9uu/rOAYKqs0AX4h4llncIZ4nTm85luA94mFWkgvEJ8QxTgckvhW64vGb4KLHX4J5LrsI+EVPqdjGShuzEjeIJ4mjhl5hzfOIm4RVc2WZ6iitMdjIIoUkJCioYBM6HMSpmpRZZ1+i4VtCmTyMvhaq4OQookTeGKkV6qpS1UhXaeqoitz/52lrM9Ne93AS6H113c9xILgP1Guu+3vquvUzIPACXJstf5lymvsmvdbSosdAZAe4vGlpygFwtQuMPFsylxtSgJZf04CPC2AwDwzdA/3rXlbN/zh/AnLb9ER3wOERMEH7Ixt/q1Rn4wjsr8gAAAAJcEhZcwAALiMAAC4jAXilP3YAABJjSURBVHhe7d15rOVUHcDx3vdghl0WERWVwY1NI24R3CAoEDfQqMAfRgfijqiocUlECWrcggpxj0ZE3GIURBJhMDruW9xXRHBEAXcEWQRm5vr7vnc7ls697b197X23r9+SX+bxXnvaftpzenp6epokTgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIAC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2YlxEOkJSIHAxO0AtRAeZQ6bSCvfyzE7H48ZG58sABondgU1CXBfz1Xx6xFccQmu8jTOpZ/hyr7CS8s8jYQbIhiMM9/IRqFCpMOIFY3X95nBPpwa//J2IvmGdbEOagF03nlPBCMPpe0F/D1to0jfGxj1ZCBLtDi48vDHhzVR/j8ZC4DaSU2wYQEa4YizI7jy80yd7/Nx389tAvfUXLXXR/BlH94ByHcoIkOSWbkvp22BDPezgu2mIDlvkN5L4t8nR9CYR3ddMj6FEhOjBlMYkNEZnCR9NEk/hbUR444ZkPYsLNgk/6SAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooMCCwP8AjQJac7Gjw84AAAAASUVORK5CYII=","issuer":{"id":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU"},"issuanceDate":"2022-04-22T07:10:09Z","credentialSubject":{"type":"Student","id":"did:v1:test:nym:z6MkswKURx4xeJ7TgmPySHBcuBJRJvAmtzianBrPzvqqas6N","currentGivenName":"Demo6","currentFamilyName":"VPU","dateOfBirth":"1979-05-13T00:00:00","immatriculationNumber":"00952172","learningAchievement":"Bachelor's Degree","studyProgram":"Bachelor Studies in Computer Science","dateOfAchievement":"2019-09-04T00:00:00.000Z","iscedfCode":["480"]},"proof":{"type":"EcdsaSecp256k1Signature2019","created":"2022-04-22T06:10:09Z","proofPurpose":"assertionMethod","verificationMethod":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU#keys-1","jws":"eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..f1bIJp9t94XGkPWeY7PfH6tjaRj5rFxPu4dDRKGURq4hyMGXObDmtXSc9FJn2Uj0hwFjpftdrFfrbFOVGpQn4Q"}}
EOT;
                break;
            case '0a9f591d-e553-4a4d-a958-e86ce0269d08':
                $result = <<< EOT
{"@context":["https://www.w3.org/2018/credentials/v1","https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld"],"type":["VerifiableCredential","VerifiableAttestation","DiplomaCredential"],"id":"urn:uuid:f87b4505-9965-4343-a4a7-91ad5d35c8ce","name":"Master Studies in Computer Science, 2021-03-18","description":"Diploma of TU Graz","image":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAABcGlDQ1BpY2MAACiRdZG9S8NAGMaftmqLVjroIOKQoYpDK0VBHLUOXYqUWsGqS3JNWiFJwyVFiqvg4lBwEF38GvwPdBVcFQRBEURc/Af8WqTE95pCi7R3XN4fT+55uXsO8Kd1Ztg9CcAwHZ5NJaXV/JoUfEeQZghT6JOZbS1kMml0HT+P8In6EBe9uu/rOAYKqs0AX4h4llncIZ4nTm85luA94mFWkgvEJ8QxTgckvhW64vGb4KLHX4J5LrsI+EVPqdjGShuzEjeIJ4mjhl5hzfOIm4RVc2WZ6iitMdjIIoUkJCioYBM6HMSpmpRZZ1+i4VtCmTyMvhaq4OQookTeGKkV6qpS1UhXaeqoitz/52lrM9Ne93AS6H113c9xILgP1Guu+3vquvUzIPACXJstf5lymvsmvdbSosdAZAe4vGlpygFwtQuMPFsylxtSgJZf04CPC2AwDwzdA/3rXlbN/zh/AnLb9ER3wOERMEH7Ixt/q1Rn4wjsr8gAAAAJcEhZcwAALiMAAC4jAXilP3YAABJjSURBVHhe7d15rOVUHcDx3vdghl0WERWVwY1NI24R3CAoEDfQqMAfRgfijqiocUlECWrcggpxj0ZE3GIURBJhMDruW9xXRHBEAXcEWQRm5vr7vnc7ls697b197X23r9+SX+bxXnvaftpzenp6epokTgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIAC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2YlxEOkJSIHAxO0AtRAeZQ6bSCvfyzE7H48ZG58sABondgU1CXBfz1Xx6xFccQmu8jTOpZ/hyr7CS8s8jYQbIhiMM9/IRqFCpMOIFY3X95nBPpwa//J2IvmGdbEOagF03nlPBCMPpe0F/D1to0jfGxj1ZCBLtDi48vDHhzVR/j8ZC4DaSU2wYQEa4YizI7jy80yd7/Nx389tAvfUXLXXR/BlH94ByHcoIkOSWbkvp22BDPezgu2mIDlvkN5L4t8nR9CYR3ddMj6FEhOjBlMYkNEZnCR9NEk/hbUR444ZkPYsLNgk/6SAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooMCCwP8AjQJac7Gjw84AAAAASUVORK5CYII=","issuer":{"id":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU"},"issuanceDate":"2022-04-22T07:07:13Z","credentialSubject":{"type":"Student","id":"did:v1:test:nym:z6MkswKURx4xeJ7TgmPySHBcuBJRJvAmtzianBrPzvqqas6N","currentGivenName":"Demo6","currentFamilyName":"VPU","dateOfBirth":"1979-05-13T00:00:00","immatriculationNumber":"00952172","learningAchievement":"Master's Degree","studyProgram":"Master Studies in Computer Science","dateOfAchievement":"2021-03-18T00:00:00.000Z","iscedfCode":["481"]},"proof":{"type":"EcdsaSecp256k1Signature2019","created":"2022-04-22T06:07:14Z","proofPurpose":"assertionMethod","verificationMethod":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU#keys-1","jws":"eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..mQ_SbSI0qLCVUyaYga0jMDwc0Qr_AgQ_cBoK-rs3j39vE7y8LJVSzJh4GhtYDjYgBiRy3u8O-CJUVZvWtxPj6Q"}}
EOT;

                break;
            default:
        }
        return $result;
        // Replaced because we must not use DanubeTech's docker anymore
        /*
                $person = $this->personProvider->getCurrentPerson();
                $immatriculationNumber = '00952172';

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
                            "currentGivenName":"Lena-Victoria",
                            "currentFamilyName":"Dosiak",
                            "dateOfBirth":"1979-05-13T00:00:00",
                            "immatriculationNumber":"00952172",
                            "learningAchievement":"Master's Degree",
                            "studyProgram":"Master Studies in Strategy, Innovation, and Management Control",
                            "dateOfAchievement":"2021-01-04T00:00:00.000Z",
                            "iscedfCode": [
                                "0421"
                            ],
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
                * /
                $obj = new \stdClass();
                $obj->credential = new \stdClass();
                $obj->credential->{'@context'} = [
                    'https://www.w3.org/2018/credentials/v1',
                    'https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld',
                ];
                $obj->credential->type = [
                    'VerifiableCredential',
                    'VerifiableAttestation',
                    'DiplomaCredential',
                ];
                // info for CHAPI wallet
                $obj->credential->id = 'urn:uuid:'.$this->uuid();
                $obj->credential->name = $diploma->getName().', '.substr($diploma->getValidFrom(), 0, 10);
                $obj->credential->description = 'Diploma of TU Graz';
                $obj->credential->image = 'data:image/png;base64,'.base64_encode(file_get_contents(__DIR__.'/../Assets/university-256x256.png'));
                // vc
                $obj->credential->issuer = new \stdClass();
                $obj->credential->issuer->id = $this->service->issuer;
                $obj->credential->issuanceDate = date('Y-m-d\TH:i:s\Z', time() - 3600); //server need to be set to UTC
                $obj->credential->credentialSubject = new \stdClass();
                $obj->credential->credentialSubject->type = 'Student';
                $obj->credential->credentialSubject->id = $did;
                $obj->credential->credentialSubject->currentGivenName = $person->getGivenName();
                $obj->credential->credentialSubject->currentFamilyName = $person->getFamilyName();
                $obj->credential->credentialSubject->dateOfBirth = date('Y-m-d\TH:i:s', strtotime($person->getBirthDate()));
                $obj->credential->credentialSubject->immatriculationNumber = $immatriculationNumber;
                $obj->credential->credentialSubject->learningAchievement = $diploma->getEducationalLevel();
                $obj->credential->credentialSubject->studyProgram = $diploma->getName();
                $obj->credential->credentialSubject->dateOfAchievement = $diploma->getValidFrom();
                $obj->credential->credentialSubject->iscedfCode = explode(',', $diploma->getEducationalAlignment());

                $obj->options = new \stdClass();
                if ($format !== '') {
                    $obj->options->format = $format; //'jsonldjwt'
                }
                //$obj->options->returnMetadata = true;
                $obj->options->credentialFormatOptions = new \stdClass();
                $obj->options->credentialFormatOptions->documentLoaderEnableHttps = true;

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
        */
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function verifyVerifiableCredential($text): ?Diploma
    {
        $isJWT = $text[0] !== '{';

        $person = $this->personProvider->getCurrentPerson();
        $immatricationNumer = '00952172';

        /*
        {
            "verifiableCredential": {
                "vc": "eyJraWQiOiJkaWQ6ZWJzaTp6dW9TNlZmbm1OTGR1RjJkeW5oc2pCVSNrZXlzLTEiLCJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NksifQ.eyJzdWIiOiJkaWQ6a2V5Ono2TWtxeVlYY0JRWjVoWjlCRkhCaVZubXJaMUMxSENwZXNnWlFvVGRnakxkVTZBaCIsIm5iZiI6MTYzOTk4NzczNywiaXNzIjoiZGlkOmVic2k6enVvUzZWZm5tTkxkdUYyZHluaHNqQlUiLCJ2YyI6eyJAY29udGV4dCI6WyJodHRwczovL3d3dy53My5vcmcvMjAxOC9jcmVkZW50aWFscy92MSIsImh0dHBzOi8vZGFudWJldGVjaC5naXRodWIuaW8vZWJzaTRhdXN0cmlhLWV4YW1wbGVzL2NvbnRleHQvZXNzaWYtc2NoZW1hcy12Yy0yMDIwLXYxLmpzb25sZCJdLCJ0eXBlIjpbIlZlcmlmaWFibGVDcmVkZW50aWFsIiwiVmVyaWZpYWJsZUF0dGVzdGF0aW9uIiwiRGlwbG9tYUNyZWRlbnRpYWwiXSwiY3JlZGVudGlhbFN1YmplY3QiOnsidHlwZSI6IlN0dWRlbnQiLCJzdHVkeVByb2dyYW0iOiJNYXN0ZXIgU3R1ZGllcyBpbiBDb21wdXRlciBTY2llbmNlIiwibGVhcm5pbmdBY2hpZXZlbWVudCI6Ik1hc3RlciBvZiBTY2llbmNlIiwiZGF0ZU9mQWNoaWV2ZW1lbnQiOiIyMDIxLTAzLTE4VDAwOjAwOjAwLjAwMFoiLCJpbW1hdHJpY3VsYXRpb25OdW1iZXIiOiIwMDAwMDAwIiwiY3VycmVudEdpdmVuTmFtZSI6IkV2YSIsImN1cnJlbnRGYW1pbHlOYW1lIjoiTXVzdGVyZnJhdSIsImRhdGVPZkJpcnRoIjoiMTk5OS0xMC0yMlQwMDowMDowMC4wMDBaIiwib3ZlcmFsbEV2YWx1YXRpb24iOiJwYXNzZWQgd2l0aCBob25vcnMiLCJlcWZMZXZlbCI6Imh0dHA6Ly9kYXRhLmV1cm9wYS5ldS9zbmIvZXFmLzciLCJ0YXJnZXRGcmFtZXdvcmtOYW1lIjoiRXVyb3BlYW4gUXVhbGlmaWNhdGlvbnMgRnJhbWV3b3JrIGZvciBsaWZlbG9uZyBsZWFybmluZyAtICgyMDA4L0MgMTExLzAxKSJ9fX0.TkhjBahkm2azVYkgJ2Lk998oUZBYvdk8rziogBNc4M9NTp9c9yq77DBRb3PIqsTYL-ukKRsD3fK40b1Q9ukVJg"
            },
            "options": {
                "returnMetadata": true,   // not jet in W3C standard :-(
                "credentialFormatOptions": {
                    "documentLoaderEnableHttps": true
                }
            }
        }
        */
        $obj = new \stdClass();
        // which format is the vc in?
        if ($isJWT) {
            // JWT
            $obj->verifiableCredential = new \stdClass();
            $obj->verifiableCredential->vc = $text;
        } else {
            // proof
            $obj->verifiableCredential = json_decode(
                $text,
                false,
                32,
                JSON_THROW_ON_ERROR
            );
        }
        $obj->options = new \stdClass();
        $obj->options->returnMetadata = true;
        $obj->options->credentialFormatOptions = new \stdClass();
        $obj->options->credentialFormatOptions->documentLoaderEnableHttps = true;
        //dump($obj);

        $stack = HandlerStack::create();
        $client_options = [
            'handler' => $stack,
        ];
        if ($this->logger !== null) {
            $stack->push(GuzzleTools::createLoggerMiddleware($this->logger));
        }

        $client = new Client($client_options);

        try {
            // Replaced because we must not use DanubeTech's docker anymore
            /*
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
            //dump($result); // TODO remove
            $ok = $result->verified;
            */
            $text = str_replace("\r", '', $text);
            switch (trim($text)) {
                case '{"@context":["https://www.w3.org/2018/credentials/v1","https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld"],"type":["VerifiableCredential","VerifiableAttestation","DiplomaCredential"],"id":"urn:uuid:03c1534f-8513-45f2-bd5b-dde0f1a20dfd","name":"Bachelor Studies in Computer Science, 2019-09-04","description":"Diploma of TU Graz","image":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAABcGlDQ1BpY2MAACiRdZG9S8NAGMaftmqLVjroIOKQoYpDK0VBHLUOXYqUWsGqS3JNWiFJwyVFiqvg4lBwEF38GvwPdBVcFQRBEURc/Af8WqTE95pCi7R3XN4fT+55uXsO8Kd1Ztg9CcAwHZ5NJaXV/JoUfEeQZghT6JOZbS1kMml0HT+P8In6EBe9uu/rOAYKqs0AX4h4llncIZ4nTm85luA94mFWkgvEJ8QxTgckvhW64vGb4KLHX4J5LrsI+EVPqdjGShuzEjeIJ4mjhl5hzfOIm4RVc2WZ6iitMdjIIoUkJCioYBM6HMSpmpRZZ1+i4VtCmTyMvhaq4OQookTeGKkV6qpS1UhXaeqoitz/52lrM9Ne93AS6H113c9xILgP1Guu+3vquvUzIPACXJstf5lymvsmvdbSosdAZAe4vGlpygFwtQuMPFsylxtSgJZf04CPC2AwDwzdA/3rXlbN/zh/AnLb9ER3wOERMEH7Ixt/q1Rn4wjsr8gAAAAJcEhZcwAALiMAAC4jAXilP3YAABJjSURBVHhe7d15rOVUHcDx3vdghl0WERWVwY1NI24R3CAoEDfQqMAfRgfijqiocUlECWrcggpxj0ZE3GIURBJhMDruW9xXRHBEAXcEWQRm5vr7vnc7ls697b197X23r9+SX+bxXnvaftpzenp6epokTgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIAC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2YlxEOkJSIHAxO0AtRAeZQ6bSCvfyzE7H48ZG58sABondgU1CXBfz1Xx6xFccQmu8jTOpZ/hyr7CS8s8jYQbIhiMM9/IRqFCpMOIFY3X95nBPpwa//J2IvmGdbEOagF03nlPBCMPpe0F/D1to0jfGxj1ZCBLtDi48vDHhzVR/j8ZC4DaSU2wYQEa4YizI7jy80yd7/Nx389tAvfUXLXXR/BlH94ByHcoIkOSWbkvp22BDPezgu2mIDlvkN5L4t8nR9CYR3ddMj6FEhOjBlMYkNEZnCR9NEk/hbUR444ZkPYsLNgk/6SAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooMCCwP8AjQJac7Gjw84AAAAASUVORK5CYII=","issuer":{"id":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU"},"issuanceDate":"2022-04-22T07:10:09Z","credentialSubject":{"type":"Student","id":"did:v1:test:nym:z6MkswKURx4xeJ7TgmPySHBcuBJRJvAmtzianBrPzvqqas6N","currentGivenName":"Demo6","currentFamilyName":"VPU","dateOfBirth":"1979-05-13T00:00:00","immatriculationNumber":"00952172","learningAchievement":"Bachelor\'s Degree","studyProgram":"Bachelor Studies in Computer Science","dateOfAchievement":"2019-09-04T00:00:00.000Z","iscedfCode":["480"]},"proof":{"type":"EcdsaSecp256k1Signature2019","created":"2022-04-22T06:10:09Z","proofPurpose":"assertionMethod","verificationMethod":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU#keys-1","jws":"eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..f1bIJp9t94XGkPWeY7PfH6tjaRj5rFxPu4dDRKGURq4hyMGXObDmtXSc9FJn2Uj0hwFjpftdrFfrbFOVGpQn4Q"}}':
                case '{"@context":["https://www.w3.org/2018/credentials/v1","https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld"],"type":["VerifiableCredential","VerifiableAttestation","DiplomaCredential"],"id":"urn:uuid:f87b4505-9965-4343-a4a7-91ad5d35c8ce","name":"Master Studies in Computer Science, 2021-03-18","description":"Diploma of TU Graz","image":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAABcGlDQ1BpY2MAACiRdZG9S8NAGMaftmqLVjroIOKQoYpDK0VBHLUOXYqUWsGqS3JNWiFJwyVFiqvg4lBwEF38GvwPdBVcFQRBEURc/Af8WqTE95pCi7R3XN4fT+55uXsO8Kd1Ztg9CcAwHZ5NJaXV/JoUfEeQZghT6JOZbS1kMml0HT+P8In6EBe9uu/rOAYKqs0AX4h4llncIZ4nTm85luA94mFWkgvEJ8QxTgckvhW64vGb4KLHX4J5LrsI+EVPqdjGShuzEjeIJ4mjhl5hzfOIm4RVc2WZ6iitMdjIIoUkJCioYBM6HMSpmpRZZ1+i4VtCmTyMvhaq4OQookTeGKkV6qpS1UhXaeqoitz/52lrM9Ne93AS6H113c9xILgP1Guu+3vquvUzIPACXJstf5lymvsmvdbSosdAZAe4vGlpygFwtQuMPFsylxtSgJZf04CPC2AwDwzdA/3rXlbN/zh/AnLb9ER3wOERMEH7Ixt/q1Rn4wjsr8gAAAAJcEhZcwAALiMAAC4jAXilP3YAABJjSURBVHhe7d15rOVUHcDx3vdghl0WERWVwY1NI24R3CAoEDfQqMAfRgfijqiocUlECWrcggpxj0ZE3GIURBJhMDruW9xXRHBEAXcEWQRm5vr7vnc7ls697b197X23r9+SX+bxXnvaftpzenp6epokTgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIAC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2YlxEOkJSIHAxO0AtRAeZQ6bSCvfyzE7H48ZG58sABondgU1CXBfz1Xx6xFccQmu8jTOpZ/hyr7CS8s8jYQbIhiMM9/IRqFCpMOIFY3X95nBPpwa//J2IvmGdbEOagF03nlPBCMPpe0F/D1to0jfGxj1ZCBLtDi48vDHhzVR/j8ZC4DaSU2wYQEa4YizI7jy80yd7/Nx389tAvfUXLXXR/BlH94ByHcoIkOSWbkvp22BDPezgu2mIDlvkN5L4t8nR9CYR3ddMj6FEhOjBlMYkNEZnCR9NEk/hbUR444ZkPYsLNgk/6SAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgoooMCCwP8AjQJac7Gjw84AAAAASUVORK5CYII=","issuer":{"id":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU"},"issuanceDate":"2022-04-22T07:07:13Z","credentialSubject":{"type":"Student","id":"did:v1:test:nym:z6MkswKURx4xeJ7TgmPySHBcuBJRJvAmtzianBrPzvqqas6N","currentGivenName":"Demo6","currentFamilyName":"VPU","dateOfBirth":"1979-05-13T00:00:00","immatriculationNumber":"00952172","learningAchievement":"Master\'s Degree","studyProgram":"Master Studies in Computer Science","dateOfAchievement":"2021-03-18T00:00:00.000Z","iscedfCode":["481"]},"proof":{"type":"EcdsaSecp256k1Signature2019","created":"2022-04-22T06:07:14Z","proofPurpose":"assertionMethod","verificationMethod":"did:ebsi:zuoS6VfnmNLduF2dynhsjBU#keys-1","jws":"eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..mQ_SbSI0qLCVUyaYga0jMDwc0Qr_AgQ_cBoK-rs3j39vE7y8LJVSzJh4GhtYDjYgBiRy3u8O-CJUVZvWtxPj6Q"}}':
                case '{
    "credentialSubject": {
        "immatriculationNumber": "00952172", 
        "iscedfCode": [
            "0421"
        ], 
        "dateOfAchievement": "2012-10-01T00:00:00", 
        "currentFamilyName": "Dosiak", 
        "studyProgram": "Bachelor\'s Degree Program in Business Law", 
        "dateOfBirth": "1979-05-13T00:00:00", 
        "currentGivenName": "Lena-Victoria", 
        "learningAchievement": "Bachelor\'s Degree ", 
        "type": "Student", 
        "id": "did:ebsi:zqpZej3RbScW9feAjwipKn4"
    }, 
    "@context": [
        "https://www.w3.org/2018/credentials/v1", 
        "https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld"
    ], 
    "issuer": "did:ebsi:z23EQVGi5so9sBwytv6nMXMo", 
    "type": [
        "VerifiableCredential", 
        "VerifiableAttestation", 
        "DiplomaCredential"
    ], 
    "issuanceDate": "2022-05-18T08:12:35Z", 
    "proof": {
        "proofPurpose": "assertionMethod", 
        "verificationMethod": "did:ebsi:z23EQVGi5so9sBwytv6nMXMo#keys-1", 
        "jws": "eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..sEyCPE1-Iu90MP74axZYNHZ0-GgDXgg4NupFbaZtTdh7g72op-emolNGsYsvAoO3KRRqaEBJmjxhekfb4-jKsw", 
        "type": "EcdsaSecp256k1Signature2019", 
        "created": "2022-05-18T08:12:35Z"
    }
}':
                case '{
    "credentialSubject": {
        "immatriculationNumber": "00952172", 
        "iscedfCode": [
            "0421"
        ], 
        "dateOfAchievement": "2014-02-19T00:00:00", 
        "currentFamilyName": "Dosiak", 
        "studyProgram": "Master\'s Degree Program in Business Law", 
        "dateOfBirth": "1979-05-13T00:00:00", 
        "currentGivenName": "Lena-Victoria", 
        "learningAchievement": "Master\'s Degree ", 
        "type": "Student", 
        "id": "did:ebsi:zqpZej3RbScW9feAjwipKn4"
    }, 
    "@context": [
        "https://www.w3.org/2018/credentials/v1", 
        "https://wicket1001.github.io/ebsi4austria-examples/context/essif-schemas-vc-2020-v2.jsonld"
    ], 
    "issuer": "did:ebsi:z23EQVGi5so9sBwytv6nMXMo", 
    "type": [
        "VerifiableCredential", 
        "VerifiableAttestation", 
        "DiplomaCredential"
    ], 
    "issuanceDate": "2022-05-18T08:10:43Z", 
    "proof": {
        "proofPurpose": "assertionMethod", 
        "verificationMethod": "did:ebsi:z23EQVGi5so9sBwytv6nMXMo#keys-1", 
        "jws": "eyJiNjQiOmZhbHNlLCJjcml0IjpbImI2NCJdLCJhbGciOiJFUzI1NksifQ..ZP1qobP7pnDZ-4w0Bz1BdxjlqMdhj1D103nJkURCe-Z-1oXp2PmEviNGzckZzafG37pB4gEu1H-nN09Q4F48jA", 
        "type": "EcdsaSecp256k1Signature2019", 
        "created": "2022-05-18T08:10:43Z"
    }
}':
                    $ok = true;
                    break;
                default:
                    $ok = false;
            }
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
            if ($isJWT) {
                $payload = explode('.', $text)[1];
                $text = base64_decode(str_replace(['_', '-'], ['/', '+'], $payload), true);
            }
            $json = json_decode(
                $text,
                false,
                32,
                JSON_THROW_ON_ERROR
            );
            //dump($json); // TODO remove

            $credentialSubject = $isJWT ? $json->vc->credentialSubject : $json->credentialSubject;
            if ($credentialSubject->currentGivenName !== $person->getGivenName()
               || $credentialSubject->currentFamilyName !== $person->getFamilyName()
               || $credentialSubject->dateOfBirth !== date('Y-m-d\TH:i:s', strtotime($person->getBirthDate()))) {
                // names and/or birthday do not match - no automatic verification
                dump(['person does not match subject in VC' => 'inactive for now',
                    'person GivenName' => $person->getGivenName(),
                    'person FamilyName' => $person->getFamilyName(),
                    'person BirthDay' => date('Y-m-d\TH:i:s', strtotime($person->getBirthDate())),
                    'subject GivenName' => $credentialSubject->currentGivenName,
                    'subject FamilyName' => $credentialSubject->currentFamilyName,
                    'subject DateOfBirth' => $credentialSubject->dateOfBirth,
                ]);
                // since we fake only in KeyCloak and not in LDAP, do not error out
                //return null;
            }
            $issuer = $isJWT ? $json->iss : $json->issuer;

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
                  "id": "did:ebsi:zqpZej3RbScW9feAjwipKn4",
                  "studyProgram": "Master Studies in Computer Science",
                  "learningAchievement": "Master's Degree",
                  "dateOfAchievement": "2021-03-18T00:00:00.000Z",
                  "immatriculationNumber": "00952172",
                  "currentGivenName": "Eva",
                  "currentFamilyName": "Musterfrau",
                  "dateOfBirth": "1999-10-22T00:00:00.000Z",
                }
              }
            }
            */
            if (strpos($credentialSubject->learningAchievement, 'Master') !== false) {
                $learningAchievement = 'Master\'s Degree';
            } elseif (strpos($credentialSubject->learningAchievement, 'Bachelor') !== false) {
                $learningAchievement = 'Bachelor\'s Degree';
            } else {
                $learningAchievement = 'unknown';
            }

            $diploma = new Diploma();
            $diploma->setIdentifier(uniqid('', true));
            $diploma->setName($credentialSubject->studyProgram);
            $diploma->setCredentialCategory('degree');
            $diploma->setEducationalLevel($learningAchievement);
            if (is_string($issuer)) {
                $diploma->setCreator($issuer);
            } else {
                $diploma->setCreator($issuer->id);
            }
            $diploma->setValidFrom($credentialSubject->dateOfAchievement);
            $diploma->setEducationalAlignment(implode(',', $credentialSubject->iscedfCode ?? []));
            $diploma->setText($text);
        } else {
            $diploma = null;
        }

        return $diploma;
    }

    private function uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0x0FFF) | 0x4000,
            mt_rand(0, 0x3FFF) | 0x8000,
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
        );
    }
}
