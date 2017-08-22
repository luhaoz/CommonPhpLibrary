<?php
/**
 * Created by PhpStorm.
 * User: luhao
 * Date: 2017/3/2
 * Time: 10:57
 */

namespace luhaoz\cpl\traits;

/**
 * Trait StaticInstance
 * @package luhaoz\cpl\dependence
 */
trait StaticInstance
{
    protected static $instance;

    /**
     * @return $this
     */
    public static function instance()
    {
        if (!static::$instance instanceof static) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}