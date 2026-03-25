<?php

namespace Softspring\TwigExtraBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\Twig\Extension\EncoreEntrySourcesExtension;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Twig\TwigFunction;

class EncoreEntrySourcesExtensionTest extends TestCase
{
    public function testGetFunctions(): void
    {
        $entrypointLookup = $this->createStub(EntrypointLookupInterface::class);
        $extension = new EncoreEntrySourcesExtension($entrypointLookup, '/tmp');
        $functions = $extension->getFunctions();

        $this->assertSame(2, count($functions));
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
        $this->assertInstanceOf(TwigFunction::class, $functions[1]);
    }

    public function testReadsCssAndJsSources(): void
    {
        $tmpDir = sys_get_temp_dir().'/twig-extra-'.uniqid('', true);
        mkdir($tmpDir);
        file_put_contents($tmpDir.'/app.css', 'body { color: red; }');
        file_put_contents($tmpDir.'/app.js', 'console.log("ok");');

        $entrypointLookup = $this->createStub(EntrypointLookupInterface::class);
        $entrypointLookup->method('getCssFiles')->willReturn(['/app.css']);
        $entrypointLookup->method('getJavaScriptFiles')->willReturn(['/app.js']);

        $extension = new EncoreEntrySourcesExtension($entrypointLookup, $tmpDir);

        try {
            $this->assertSame('body { color: red; }', $extension->getCssSource('app'));
            $this->assertSame('console.log("ok");', $extension->getJsSource('app'));
        } finally {
            unlink($tmpDir.'/app.css');
            unlink($tmpDir.'/app.js');
            rmdir($tmpDir);
        }
    }
}
