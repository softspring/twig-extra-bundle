<?php

namespace Softspring\TwigExtraBundle\DependencyInjection\Compiler;

use Softspring\TwigExtraBundle\Twig\ExtensibleAppVariable;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ExtensibleAppVariablePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('twig.app_variable')) {
            $definition = $container->getDefinition('twig.app_variable');
            $definition->setClass(ExtensibleAppVariable::class);
        }
    }
}
