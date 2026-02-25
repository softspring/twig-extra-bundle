<?php

namespace Softspring\TwigExtraBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\Twig\Extension\RoutingExtension;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Twig\TwigFunction;

class RoutingExtensionTest extends TestCase
{
    public function testGetFunctions(): void
    {
        $urlGenerator = $this->getMockBuilder(UrlGenerator::class)->disableOriginalConstructor()->getMock();
        $extension = new RoutingExtension($urlGenerator);
        $functions = $extension->getFunctions();
        $this->assertSame(1, count($functions));
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
    }

    public function testRouteDefined(): void
    {
        $urlGenerator = $this->getMockBuilder(UrlGenerator::class)->disableOriginalConstructor()->getMock();
        $extension = new RoutingExtension($urlGenerator);

        $urlGenerator->expects($this->once())->method('generate')->willReturn('/generated/url');

        $this->assertTrue($extension->isRouteDefined('route'));
    }

    public function testRouteDefinedWithMissingParameters(): void
    {
        $urlGenerator = $this->getMockBuilder(UrlGenerator::class)->disableOriginalConstructor()->getMock();
        $extension = new RoutingExtension($urlGenerator);

        $urlGenerator->expects($this->once())->method('generate')->will($this->throwException(new MissingMandatoryParametersException()));

        $this->assertTrue($extension->isRouteDefined('route'));
    }

    public function testRouteDefinedWithInvalidParameter(): void
    {
        $urlGenerator = $this->getMockBuilder(UrlGenerator::class)->disableOriginalConstructor()->getMock();
        $extension = new RoutingExtension($urlGenerator);

        $urlGenerator->expects($this->once())->method('generate')->will($this->throwException(new InvalidParameterException()));

        $this->assertTrue($extension->isRouteDefined('route'));
    }

    public function testRouteNotDefined(): void
    {
        $urlGenerator = $this->getMockBuilder(UrlGenerator::class)->disableOriginalConstructor()->getMock();
        $extension = new RoutingExtension($urlGenerator);

        $urlGenerator->expects($this->once())->method('generate')->will($this->throwException(new RouteNotFoundException()));

        $this->assertFalse($extension->isRouteDefined('route'));
    }
}
