<?php

namespace Softspring\TwigExtraBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ActiveForRoutesExtension extends AbstractExtension
{
    protected RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('active_for_routes', [$this, 'activeForRoutes']),
        ];
    }

    /**
     * Replaces twig compare function for adding "active" class:
     *      app.request.attributes.get('_route') starts with 'admin_dashboard' ? 'active': ''.
     */
    public function activeForRoutes(string $routesStartsWith, bool $andCondition = null, string $class = 'active'): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return '';
        }

        $route = $request->attributes->get('_route');

        if (preg_match("/^$routesStartsWith/i", $route) || preg_match("/^admin_$routesStartsWith/i", $route)) {
            return null === $andCondition || true === $andCondition ? $class : '';
        }

        return '';
    }
}
