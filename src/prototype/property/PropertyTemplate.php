<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\prototype\property;


class PropertyTemplate
{
    protected static $templates = [];

    public static function template($template, $configs = [])
    {
        if (!array_key_exists($template, static::$templates)) {
            static::$templates[$template] = [];
        }

        if (!empty($configs)) {
            static::$templates[$template] = $configs;
        }

        return static::$templates[$template];
    }
}