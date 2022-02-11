<?php

namespace Softspring\TwigExtraBundle\Twig;

use Symfony\Bridge\Twig\AppVariable as BaseAppVariable;

class ExtensibleAppVariable extends BaseAppVariable
{
    protected array $extraData = [];

    public function __call($method, $params)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $params);
        }

        $key = lcfirst(substr($method, 3));

        if (0 === strncasecmp($method, 'get', 3)) {
            return $this->extraData[$key];
        }
        if (0 === strncasecmp($method, 'set', 3)) {
            $this->extraData[$key] = $params[0];
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        if (isset($this->extraData[$property])) {
            return $this->extraData[$property];
        }

        return null;
    }

    public function __isset($property)
    {
        if (property_exists($this, $property)) {
            return true;
        }

        return isset($this->extraData[$property]);
    }
}
