<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\validate\base;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\error\Error;
use luhaoz\cpl\error\traits\ErrorManager;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\prototype\traits\Prototype;

class BaseValidator
{
    const VALIDATOR_NAME = 'validator';
    use Prototype;
    use ErrorManager;
    public $message;
    public $name;


    public function validate($data)
    {
        $valid = boolval($this->valid($data));
        if (!$valid) {
            $error = new Error();
            $error->prototype()->properties()->config('type', Dependence::dependenceConfig(Value::class));
            $error->type = static::VALIDATOR_NAME;
            $error->message = $this->message;
            $error->name = $this->name;
            $this->errors()->add($error);
        }
        return $valid;
    }

    protected function valid($data)
    {

    }
}