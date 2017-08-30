<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\behavior\base;

use luhaoz\cpl\prototype\traits\Prototype;

class BaseBehavior
{
    public $behavior = null;
    protected $_owner = null;

    public function owner($owner = null)
    {
        if ($owner !== null) {
            $this->_owner = $owner;
        }
        return $this->_owner;
    }

    public function run($arguments = [])
    {
        $run = $this->behavior;
        if (is_array($run)) {
            list($methodInstance, $methodName) = $run;
            $reflectionMethod = new \ReflectionMethod(get_class($methodInstance), $methodName);
            $run = $reflectionMethod->getClosure($methodInstance);
        }
        $run = \Closure::bind($run, $this->owner(), get_class($this->owner()));
        return call_user_func_array($run, $arguments);
    }

}