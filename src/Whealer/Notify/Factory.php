<?php
namespace Whealer\Notify;
class Factory
{
    public static function get($service, array $arguments)
    {
        $class = ucwords($service);
        return $class::getInstance($arguments);
    }
}
