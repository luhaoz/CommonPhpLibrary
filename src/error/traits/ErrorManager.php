<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 15:25
 */

namespace luhaoz\cpl\error\traits;

trait ErrorManager
{
    protected $_errorPool = null;

    public function errors()
    {
        if ($this->_errorPool === null) {
            $this->_errorPool = new \luhaoz\cpl\error\ErrorManager();
        }
        return $this->_errorPool;
    }
}