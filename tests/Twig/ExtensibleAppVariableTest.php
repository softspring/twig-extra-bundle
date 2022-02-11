<?php

namespace Softspring\TwigExtraBundle\Tests\Twig;

use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\Twig\ExtensibleAppVariable;

class ExtensibleAppVariableTest extends TestCase
{
    public function testSuccess()
    {
        $app = new ExtensibleAppVariable();

        $app->setTestField('account');

        $this->assertTrue(isset($app->testField));
        $this->assertFalse(isset($app->missingField));
        $this->assertEquals('account', $app->getTestField());
    }

    public function testCallExistingMethod()
    {
        $app = new ExtensibleAppVariable();
        $app->setEnvironment('test');
        $this->assertEquals('test', $app->getEnvironment());
    }
}
