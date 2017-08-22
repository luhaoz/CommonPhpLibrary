<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\property\types;

use luhaoz\cpl\prototype\property\base\BaseProperty;

class Junctor extends Value
{
    protected $_junctorInstance = null;


    /**
     * @param null $nativeInstance
     * @return BaseProperty
     */
    public function junctorInstance($junctorInstance = null)
    {
        if ($junctorInstance !== null) {
            $this->_junctorInstance = $junctorInstance;
        }
        return $this->_junctorInstance;
    }

    public function set($value)
    {
        return $this->junctorInstance()->set($value);
    }

    public function get()
    {
        return $this->junctorInstance()->get();
    }

    public function toData()
    {
        return $this->junctorInstance()->toData();
    }
}