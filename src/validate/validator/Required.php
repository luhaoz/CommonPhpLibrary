<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 16:17
 */

namespace luhaoz\cpl\validate\validator;

use luhaoz\cpl\validate\base\BaseValidator;

class Required extends BaseValidator
{
    const VALIDATOR_NAME = 'required';

    protected function valid($data)
    {
        return $data !== null;
    }
}