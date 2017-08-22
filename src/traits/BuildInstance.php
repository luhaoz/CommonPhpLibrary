<?php
/**
 * Created by PhpStorm.
 * User: luhao
 * Date: 2017/3/2
 * Time: 10:57
 */

namespace luhaoz\cpl\traits;
/**
 * Trait BuildInstance
 * @package luhaoz\cpl\dependence
 */
trait BuildInstance
{
    public static function instantiate($initializtion = null)
    {
        $instance = new static();
        if ($initializtion instanceof \Closure) {
            call_user_func_array($initializtion, [$instance]);
        }
        return $instance;
    }
}