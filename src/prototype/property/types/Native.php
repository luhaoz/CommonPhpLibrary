<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\property\types;

use luhaoz\cpl\prototype\traits\Prototype;

class Native extends Value
{
    protected $_nativeInstance = null;

    /**
     * @param null $nativeInstance
     * @return \ReflectionProperty
     */
    public function nativeInstance($nativeInstance = null)
    {
        if ($nativeInstance !== null) {
            $this->_nativeInstance = $nativeInstance;
        }
        return $this->_nativeInstance;
    }

    public function set($value)
    {
        return $this->nativeInstance()->setValue($this->owner(), $value);
    }

    public function get()
    {
        return $this->nativeInstance()->getValue($this->owner());
    }
}