<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/5/17
 * Time: 11:02
 */

namespace luhaoz\cpl\api\exception;


use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\BuildInstance;

class ApiHttpException extends \Exception
{
    use BuildInstance;
    use Prototype;

    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->propertys()->configs([
            'data'       => Dependence::dependenceMapper(Value::class),
            'statusCode' => Dependence::dependenceMapper(Value::class),
        ]);
    }

    public function build($code, $message, $data = null)
    {
        $instantiate = static::instantiate();
        $instantiate->statusCode = $code;
        $instantiate->message = $message;
        if ($data !== null) {
            $instantiate->data = $data;
        }
        return $instantiate;
    }
}