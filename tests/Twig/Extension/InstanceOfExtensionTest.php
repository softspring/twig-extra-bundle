<?php

namespace Softspring\TwigExtraBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\Twig\Extension\InstanceOfExtension;
use Twig\TwigTest;

class InstanceOfExtensionTest extends TestCase
{
    public function testGetTests()
    {
        $extension = new InstanceOfExtension();
        $tests = $extension->getTests();
        $this->assertSame(1, sizeof($tests));
        $this->assertInstanceOf(TwigTest::class, $tests[0]);
    }

    public function testInstanceOf()
    {
        $extension = new InstanceOfExtension();

        $this->assertTrue($extension->instanceOf(new \Exception(), '\\Exception'));
        $this->assertFalse($extension->instanceOf(new \Exception(), '\\OtherClass'));
        $this->assertFalse($extension->instanceOf('a string', '\\stdClass'));
        $this->assertFalse($extension->instanceOf(123, '\\stdClass'));
        $this->assertFalse($extension->instanceOf(null, '\\stdClass'));
        $this->assertFalse($extension->instanceOf(false, '\\stdClass'));
        $this->assertFalse($extension->instanceOf(true, '\\stdClass'));
    }
}
