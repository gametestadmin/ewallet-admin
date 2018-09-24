<?php
namespace System\Widgets;

class Manager
{
    public static function get($widgetClass, $parameters = null)
    {
        $widgetClass = '\System\Widgets\\' . $widgetClass;

        return new $widgetClass($parameters);
    }
}
