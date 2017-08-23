<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\validate;

use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\error\traits\ErrorManager;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\validate\base\BaseValidator;


class ValidateResult
{
    use ErrorManager;
    protected $_valid = true;

    public function valid($valid = null)
    {
        if ($valid !== null) {
            $this->_valid = $valid;
        }
        return $this->_valid;
    }
}