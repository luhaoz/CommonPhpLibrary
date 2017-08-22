<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\method\types;


use luhaoz\cpl\prototype\method\base\BaseMethod;

class Junctor extends BaseMethod
{
    protected $_junctorInstance = null;


    /**
     * @param null $nativeInstance
     * @return BaseMethod
     */
    public function junctorInstance($junctorInstance = null)
    {
        if ($junctorInstance !== null) {
            $this->_junctorInstance = $junctorInstance;
        }
        return $this->_junctorInstance;
    }

    public function method($method = null)
    {
        return $this->junctorInstance()->method();
    }
}