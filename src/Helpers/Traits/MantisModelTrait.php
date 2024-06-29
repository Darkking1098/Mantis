<?php

namespace Mantis\Helpers\Traits;

trait MantisModelTrait
{
    // Adding values in protected variabls
    protected static $m_a_f = [];
    // Removing values from protected variabls
    protected static $m_r_f = [];

    // Add events
    protected static $m_a_e = [];
    // Add Global Scopes
    // protected static $m_a_gs = [];

    // To collect values that should be added
    public static function addElem($prop, $val)
    {
        static::$m_a_f[$prop] = array_merge(static::$m_a_f[$prop] ?? [], (array)$val);
    }

    // To collect values that should be removed
    public static function removeElem($prop, $val)
    {
        static::$m_r_f[$prop] = array_merge(static::$m_r_f[$prop] ?? [], (array)$val);
    }

    // Adding events
    public static function addEvent($event, $listener)
    {
        static::$m_a_e[$event][] = $listener;
    }

    // // Adding Global Scopes
    // public static function addCustomGlobalScope($name, $scope)
    // {
    //     static::$m_a_gs[$name] = $scope;
    // }
}
