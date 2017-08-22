<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\method\types;


use luhaoz\cpl\prototype\method\base\BaseMethod;

class Native extends BaseMethod
{
    protected $_nativeInstance = null;

    /**
     * @param null $nativeInstance
     * @return \ReflectionMethod
     */
    public function nativeInstance($nativeInstance = null)
    {
        if ($nativeInstance !== null) {
            $this->_nativeInstance = $nativeInstance;
        }
        return $this->_nativeInstance;
    }

    public function method($method = null)
    {
        return $this->nativeInstance()->getClosure($this->owner());
    }
}