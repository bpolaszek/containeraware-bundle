<?php

namespace BenTools\ContainerAwareBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ContainerAwareCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getServiceIds() as $serviceId) {
            $definition = $container->findDefinition($serviceId);
            $class = $definition->getClass();
            if (is_a($class, 'Symfony\Component\DependencyInjection\ContainerAwareInterface', true)) {
                $definition->addMethodCall('setContainer', array(new Reference('service_container')));
            }
        }
    }
}
