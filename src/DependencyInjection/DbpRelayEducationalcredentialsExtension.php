<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\DependencyInjection;

use Dbp\Relay\CoreBundle\Extension\ExtensionTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DbpRelayEducationalcredentialsExtension extends ConfigurableExtension
{
    use ExtensionTrait;

    public function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        // Inject the config value into the ConfigService service
        $definition = $container->getDefinition('Dbp\Relay\EducationalcredentialsBundle\Service\ConfigService');
        $definition->addArgument($mergedConfig['issuer']);
        $definition->addArgument($mergedConfig['urlIssuer']);
        $definition->addArgument($mergedConfig['urlVerifier']);
    }
}
