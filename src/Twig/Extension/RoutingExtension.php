<?php

namespace Softspring\TwigExtraBundle\Twig\Extension;

use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RoutingExtension extends AbstractExtension
{
    protected UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('route_defined', [$this, 'isRouteDefined']),
        ];
    }

    public function isRouteDefined(string $routeName): bool
    {
        try {
            $this->urlGenerator->generate($routeName, ['__twig_extra_route_defined_check' => true]);

            return true;
        } catch (MissingMandatoryParametersException|InvalidParameterException $e) {
            return true;
        } catch (RouteNotFoundException $e) {
            return false;
        }
    }
}
