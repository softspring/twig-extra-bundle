<?php

namespace Softspring\TwigExtraBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class InstanceOfExtension extends AbstractExtension
{
    /**
     * @return TwigTest[]
     */
    public function getTests(): array
    {
        return [new TwigTest('instanceof', [$this, 'instanceOf'])];
    }

    public function instanceOf(mixed $var, string $class): bool
    {
        return $var instanceof $class;
    }
}
