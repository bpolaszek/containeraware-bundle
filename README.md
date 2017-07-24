[![Latest Stable Version](https://poser.pugx.org/bentools/containeraware-bundle/v/stable)](https://packagist.org/packages/bentools/containeraware-bundle)
[![License](https://poser.pugx.org/bentools/containeraware-bundle/license)](https://packagist.org/packages/bentools/containeraware-bundle)
[![Build Status](https://img.shields.io/travis/bpolaszek/containeraware-bundle/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/containeraware-bundle)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/containeraware-bundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/containeraware-bundle)
[![Total Downloads](https://poser.pugx.org/bentools/containeraware-bundle/downloads)](https://packagist.org/packages/bentools/containeraware-bundle)

This Symfony bundle automatically injects the **Service Container** into all your services that implement `Symfony\Component\DependencyInjection\ContainerAwareInterface`.

Installation
------------
> composer require bentools/containeraware-bundle

Then, just add this bundle to your `AppKernel`.
```php
# app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new BenTools\ContainerAwareBundle\ContainerAwareBundle(),
        ];

        return $bundles;
    }
}
```

And that's it! You're ready to go. No need to edit any configuration file.

You no longer need to explicitely call `$service->setContainer($container)` in your `services.yml` or `services.xml` files.


Example usage
-------------

```php
# src/AppBundle/Services/DummyService.php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class DummyService implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function doSomethingAwesome()
    {
        $doctrine = $this->container->get('doctrine');
        // do awesome stuff
    }
}
```

```yaml
# app/config/services.yml

services:
    dummy.service:
        class: AppBundle\Services\DummyService
        #calls:
            #- [ 'setContainer', [ '@service_container' ] ] # // Not needed anymore
```


Compatibility
-------------

This bundle has been successfully tested against Symfony **2.7** to **3.3** / PHP **5.3** to **7.1**.

See [Travis builds](https://travis-ci.org/bpolaszek/containeraware-bundle) for more information.

Tests
-----
> ./vendor/bin/phpunit