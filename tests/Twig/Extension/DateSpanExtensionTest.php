<?php

namespace Softspring\TwigExtraBundle\Tests\Twig\Extension;

use Twig\Loader\ArrayLoader;
use DateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Softspring\TwigExtraBundle\Twig\Extension\DateSpanExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\TwigFilter;

class DateSpanExtensionTest extends TestCase
{
    public function testGetFunctions(): void
    {
        $requestStack = $this->getMockBuilder(RequestStack::class)->disableOriginalConstructor()->getMock();
        $extension = new DateSpanExtension($requestStack);

        /** @var TwigFilter[] $filters */
        $filters = $extension->getFilters();
        $this->assertSame(1, count($filters));

        // check filter configuration
        $this->assertInstanceOf(TwigFilter::class, $filters[0]);
        $this->assertTrue($filters[0]->needsEnvironment());
    }

    public static function dateSpanProvider(): array
    {
        return [
            [
                new DateTime('2000-01-01 11:30:59'),
                'H:i:s d-m-Y',
                'Europe/Madrid',
                '<span title="12:30:59 01-01-2000 Europe/Madrid // 11:30:59 01-01-2000 UTC">12:30:59 01-01-2000</span>',
            ],
            [
                new DateTime('2000-01-01 11:30:59'),
                'H:i:s d-m-Y',
                'GMT+4',
                '<span title="15:30:59 01-01-2000 GMT+4 // 11:30:59 01-01-2000 UTC">15:30:59 01-01-2000</span>',
            ],
            [
                new DateTime('2000-01-01 11:30:59'),
                'H:i:s d-m-Y',
                'UTC',
                '11:30:59 01-01-2000',
            ],
        ];
    }

    #[DataProvider('dateSpanProvider')]
    public function testDateSpan(DateTime $dateTime, string $format, string $utzCookie, string $expected): void
    {
        $request = new Request([], [], [], ['utz' => $utzCookie]);

        $requestStack = $this->getMockBuilder(RequestStack::class)->disableOriginalConstructor()->getMock();
        $requestStack->expects($this->once())->method('getCurrentRequest')->willReturn($request);
        $extension = new DateSpanExtension($requestStack);

        $environment = new Environment(new ArrayLoader([]));

        $returned = $extension->dateSpan($environment, $dateTime, $format);
        $this->assertEquals($expected, str_replace("\n", ' // ', $returned));
    }
}
