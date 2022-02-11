<?php

namespace Softspring\TwigExtraBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\Twig\Extension\ActiveForRoutesExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\TwigFunction;

class ActiveForRoutesExtensionTest extends TestCase
{
    public function testGetFunctions()
    {
        $extension = new ActiveForRoutesExtension(new RequestStack());
        $functions = $extension->getFunctions();
        $this->assertSame(1, sizeof($functions));
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
    }

    public function testEmptyRequest()
    {
        $stack = new RequestStack();
        $extension = new ActiveForRoutesExtension($stack);

        $this->assertEquals('', $extension->activeForRoutes('anything'));
    }

    public function testMatchingRoute()
    {
        $request = new Request();
        $request->attributes->set('_route', 'test_route');

        $stack = new RequestStack();
        $stack->push($request);
        $extension = new ActiveForRoutesExtension($stack);

        $this->assertEquals('active', $extension->activeForRoutes('test_'));
        $this->assertEquals('active', $extension->activeForRoutes('test_route'));
        $this->assertEquals('other-active-class', $extension->activeForRoutes('test_', null, 'other-active-class'));
    }

    public function testNonMatchingRoute()
    {
        $request = new Request();
        $request->attributes->set('_route', 'test_route');

        $stack = new RequestStack();
        $stack->push($request);
        $extension = new ActiveForRoutesExtension($stack);

        $this->assertEquals('', $extension->activeForRoutes('other_route'));
        $this->assertEquals('', $extension->activeForRoutes('other_route', null, 'other-active-class'));
    }

    public function testMatchingRouteWithOtherCondition()
    {
        $request = new Request();
        $request->attributes->set('_route', 'test_route');

        $stack = new RequestStack();
        $stack->push($request);
        $extension = new ActiveForRoutesExtension($stack);

        $this->assertEquals('active', $extension->activeForRoutes('test_', true));
        $this->assertEquals('active', $extension->activeForRoutes('test_route', true));
        $this->assertEquals('other-active-class', $extension->activeForRoutes('test_', true, 'other-active-class'));

        $this->assertEquals('', $extension->activeForRoutes('test_', false));
        $this->assertEquals('', $extension->activeForRoutes('test_route', false));
        $this->assertEquals('', $extension->activeForRoutes('test_', false, 'other-active-class'));
    }
}
