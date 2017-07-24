<?php

namespace BenTools\ContainerAwareBundle;

use BenTools\ContainerAwareBundle\DependencyInjection\ContainerAwareCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContainerAwareBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ContainerAwareCompilerPass());
    }
}
