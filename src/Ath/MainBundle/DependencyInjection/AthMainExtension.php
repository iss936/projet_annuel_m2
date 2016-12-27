<?php

namespace Ath\MainBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class AthMainExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $this->configureRolesApp($container, $config);
        
    }

    public function configureRolesApp(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('ath_main.form.type.roles_app');

        if (!empty($config['roles_app'])) {
            $definition->replaceArgument(0, $config['roles_app']);
        } elseif (!empty($config['roles_gp_app'])) {
            $definition->replaceArgument(0, $config['roles_gp_app']);
        } else {
            $roles = array('ROLE_USER' => 'Rôle utilisateur');
            $definition->replaceArgument(0, $roles);
        }
        $definition->replaceArgument(1, $config['is_multiple']);
        $definition->replaceArgument(2, $config['is_expanded']);
    }

    public function getAlias()
    {
        return 'ath_main';
    }
}
