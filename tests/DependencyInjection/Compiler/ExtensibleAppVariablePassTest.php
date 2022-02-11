<?php

namespace Softspring\TwigExtraBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\DependencyInjection\Compiler\ExtensibleAppVariablePass;
use Softspring\TwigExtraBundle\Twig\ExtensibleAppVariable;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ExtensibleAppVariablePassTest extends TestCase
{
    public function testProcess()
    {
        $compiler = new ExtensibleAppVariablePass();

        $container = new ContainerBuilder();
        $container->setDefinition('twig.app_variable', $twigAppVariableDefinition = new Definition());
        $container->setDefinition('templating.globals', $templatingGlobalsDefinition = new Definition());

        $compiler->process($container);
        $this->assertEquals(ExtensibleAppVariable::class, $twigAppVariableDefinition->getClass());
    }
}
