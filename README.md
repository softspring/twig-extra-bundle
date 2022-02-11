# SfsTwigExtraBundle

[![Latest Stable Version](https://poser.pugx.org/softspring/twig-extra-bundle/v/stable.svg)](https://packagist.org/packages/softspring/twig-extra-bundle)
[![Latest Unstable Version](https://poser.pugx.org/softspring/twig-extra-bundle/v/unstable.svg)](https://packagist.org/packages/softspring/twig-extra-bundle)
[![License](https://poser.pugx.org/softspring/twig-extra-bundle/license.svg)](https://packagist.org/packages/softspring/twig-extra-bundle)
[![Total Downloads](https://poser.pugx.org/softspring/twig-extra-bundle/downloads)](https://packagist.org/packages/softspring/twig-extra-bundle)
[![Build status](https://travis-ci.com/softspring/twig-extra-bundle.svg?branch=master)](https://app.travis-ci.com/github/softspring/twig-extra-bundle)

The SfsTwigExtraBundle adds some twig extra functions.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require softspring/twig-extra-bundle
```

## Extensible templating variables

This bundle provides and extensible "app" template variable, that allows appending values to it.

The following example appends a "store" variable to the global "app" object to use in twig templates:

```php
<?php

namespace App\EventListener;

use Softspring\TwigExtraBundle\Twig\ExtensibleAppVariable;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StoreRequestListener implements EventSubscriberInterface
{
    /**
     * @var AppVariable
     */
    protected $twigAppVariable;

    /**
     * @param AppVariable $twigAppVariable
     */
    public function __construct(AppVariable $twigAppVariable)
    {
        if (!$twigAppVariable instanceof ExtensibleAppVariable) {
            throw new InvalidConfigurationException('You must configure SfsTwigExtraBundle to extend twig app variable');
        }

        $this->twigAppVariable = $twigAppVariable;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onRequestGetStore', 30], // router listener has 32
            ],
        ];
    }
    
    public function onRequestGetStore(RequestEvent $event)
    {
        $this->twigAppVariable->setStore('uk');
    }
}
```

```twig
{# your twig template #}
{{ app.store }} {# returns uk #}
```


## Twig functions

### active_for_routes_extension

This extension provides a function that returns an active class for matching routes.

This is useful to create menus, options or tabs with active marks.

This function is enabled by default.

**Disable feature**

```yaml
{# config/packages/sfs_twig_extra.yaml #}
sfs_twig_extra:
    active_for_routes_extension: false        
```

**Usage**

```twig
<a href="{{ url('admin_products_list') }}" class="{{ active_for_routes('admin_products_') }}">Products</a> {# this link will have an "active" class when the current route matches with "admin_products_" #}        
<a href="{{ url('admin_products_list') }}" class="{{ active_for_routes('admin_products_', checkSomeVariable == true) }}">Products</a> {# also you can add an extra boolean expression #}        
<a href="{{ url('admin_products_list') }}" class="{{ active_for_routes('admin_products_', null, 'my-active-class') }}">Products</a> {# or change the "active" class with your "my-active-class" #}        
```

### routing_extension

This extension provides a route_defined function.

This is useful for bundles with enabling features.

This function is enabled by default.

**Disable feature**

```yaml
{# config/packages/sfs_twig_extra.yaml #}
sfs_twig_extra:
    routing_extension: false        
```

**Usage**

```twig
{# a bundle twig template #}
{% if route_defined('sfs_user_register') %}
    <a href="{{ url('sfs_user_register') }}" class="btn btn-secondary btn-block">Sign up</a>
{% endif %}
```

## License

This bundle is under the MIT license. See the complete license in the bundle LICENSE file.