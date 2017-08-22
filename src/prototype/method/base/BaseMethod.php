<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\prototype\method\base;

/**
 * Class BaseMethod
 * @package luhaoz\cpl\prototype\method\base
 */
class BaseMethod
{
    protected $_owner = null;

    public function owner($owner = null)
    {
        if ($owner !== null) {
            $this->_owner = $owner;
        }
        return $this->_owner;
    }

    protected $_method = null;

    public function method($method = null)
    {
        if ($method !== null) {
            $this->_method = $method;
        }
        return $this->_method;
    }


    public function call($parameter = null, $_ = null)
    {
        return call_user_func_array($this->method(), func_get_args());
    }

    public function callArray($arguments = [])
    {
        return call_user_func_array($this->method(), $arguments);
    }
}