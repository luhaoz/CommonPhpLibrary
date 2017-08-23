<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\method\types;

class Method extends Call
{
    public function call($parameter = null, $_ = null)
    {
        $runMethod = $this->method();
        if (is_array($runMethod)) {
            list($methodInstance, $methodName) = $runMethod;
            $reflectionMethod = new \ReflectionMethod(get_class($methodInstance), $methodName);
            $runMethod = $reflectionMethod->getClosure($methodInstance);
        }
        $runMethod = \Closure::bind($runMethod, $this->owner(), get_class($this->owner()));
        return call_user_func_array($runMethod, func_get_args());
    }

    public function callArray($arguments = [])
    {
        $runMethod = $this->method();
        if (is_array($runMethod)) {
            list($methodInstance, $methodName) = $runMethod;
            $reflectionMethod = new \ReflectionMethod(get_class($methodInstance), $methodName);
            $runMethod = $reflectionMethod->getClosure($methodInstance);
        }
        $runMethod = \Closure::bind($runMethod, $this->owner(), get_class($this->owner()));
        return call_user_func_array($runMethod, $arguments);
    }
}