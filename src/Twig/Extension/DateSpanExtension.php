<?php

namespace Softspring\TwigExtraBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateSpanExtension extends AbstractExtension
{
    protected RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('date_span', [$this, 'dateSpan'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    public function dateSpan(Environment $env, \DateTime $dateTime, string $format): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $userTimezone = $request->cookies->get('utz', 'UTC');
        $utcTime = \twig_date_format_filter($env, $dateTime, $format, 'UTC');
        $userTime = \twig_date_format_filter($env, $dateTime, $format, $userTimezone);

        if ('UTC' === $userTimezone) {
            return $utcTime;
        } else {
            return "<span title=\"$userTime $userTimezone\n$utcTime UTC\">$userTime</span>";
        }
    }
}
