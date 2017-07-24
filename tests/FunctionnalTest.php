<?php

namespace BenTools\ContainerAwareBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FunctionnalTest extends KernelTestCase
{

    protected static $class = 'BenTools\ContainerAwareBundle\Tests\Fixtures\TestKernel';

    public function testDummyService()
    {
        static::bootKernel();
        $container = static::$kernel->getContainer();
        $service = $container->get('test.container_aware_service');
        $this->assertNotNull($service);
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\ContainerInterface', $service->getContainer());
    }
}
