<?php

namespace BenTools\ContainerAwareBundle\Tests\Fixtures;

use BenTools\ContainerAwareBundle\ContainerAwareBundle;
use BenTools\ContainerAwareBundle\Tests\Fixtures\TestBundle\TestBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class TestKernel extends Kernel
{

    private $cacheDir, $logDir;

    /**
     * @inheritDoc
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $kernel = $this;
        $loader->load(function (ContainerBuilder $container) use ($loader, $kernel) {
            $container->loadFromExtension('framework', array(
                'router' => array(
                    'resource' => 'kernel:loadRoutes',
                    'type' => 'service',
                ),
                'secret' => 'MySecretKey',
                'test' => null,
            ));

            $kernel->configureContainer($container, $loader);

            $container->addObjectResource($kernel);
        });
    }

    /**
     * @internal
     */
    public function loadRoutes(LoaderInterface $loader)
    {
        $routes = new RouteCollectionBuilder($loader);
        $this->configureRoutes($routes);

        return $routes->build();
    }

    /**
     * @inheritDoc
     */
    public function registerBundles()
    {
        return array(
            new FrameworkBundle(),
            new ContainerAwareBundle(),
            new TestBundle(),
        );
    }

    /**
     * @inheritDoc
     */
    public function configureRoutes(RouteCollectionBuilder $routes)
    {
    }

    /**
     * @inheritDoc
     */
    public function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
    }

    /**
     * @inheritDoc
     */
    public function getCacheDir()
    {
        if (null === $this->cacheDir) {
            $this->cacheDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('containeraware', true) . DIRECTORY_SEPARATOR . 'cache';
            if (!is_dir($this->cacheDir)) {
                mkdir($this->cacheDir, 0777, true);
            }
        }
        return $this->cacheDir;
    }

    /**
     * @inheritDoc
     */
    public function getLogDir()
    {
        if (null === $this->logDir) {
            $this->logDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('containeraware', true) . DIRECTORY_SEPARATOR . 'logs';
            if (!is_dir($this->logDir)) {
                mkdir($this->logDir, 0777, true);
            }
        }
        return $this->logDir;
    }
}
