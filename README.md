# DbpRelayEducationalcredentialsBundle

Create *Verifiable Credentials* for your users:

- Diplomas for students


## Integration into the API Server

* Add the repository to your composer.json:

```json
    "repositories": [
        {
            "type": "vcs",
            "url": "git@gitlab.tugraz.at:dbp/relay/dbp-relay-educationalcredentials-bundle.git"
        }
    ],
```

* Add the bundle package as a dependency:

```
composer require dbp/relay-educationalcredentials-bundle=dev-main
```

* Add the bundle to your `config/bundles.php`:

```php
...
Dbp\Relay\EducationalcredentialsBundle\DbpRelayEducationalcredentialsBundle::class => ['all' => true],
DBP\API\CoreBundle\DbpCoreBundle::class => ['all' => true],
];
```

* Run `composer install` to clear caches

## Configuration

The bundle has a `issuer` configuration value that you can specify in your
app, either by hardcoding it, or by referencing an environment variable.

For this create `config/packages/dbp_relay_educationalcredentials.yaml` in the app with the following
content:

```yaml
dbp_relay_educationalcredentials:
  issuer: "did:ebsi:abc..."
  # issuer: '%env(VC_ISSUER)%'
  urlIssuer: "http://localhost:13080/1.0/credentials/issue"
  # urlIssuer: '%env(VC_URL_ISSUER)%'
  urlVerifier: "http://localhost:14080/1.0/credentials/verify"
  # urlIssuer: '%env(VC_URL_VERIFIER)%'
```

The value gets read in `DbpRelayEducationalcredentialsExtension` and passed when creating the
`ConfigService` service.

For more info on bundle configuration see
https://symfony.com/doc/current/bundles/configuration.html

## Development & Testing

* Install dependencies: `composer install`
* Run tests: `composer test`
* Run linters: `composer run lint`
* Run cs-fixer: `composer run cs-fix`

## Bundle dependencies

Don't forget you need to pull down your dependencies in your main application if you are installing packages in a bundle.

```bash
# updates and installs dependencies from dbp/relay-educationalcredentials-bundle
composer update dbp/relay-educationalcredentials-bundle
```
