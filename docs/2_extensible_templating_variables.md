# Extensible templating variables

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
