<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 17:30
 */

namespace luhaoz\cpl\error;

use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\BuildInstance;

class Error
{
    use BuildInstance;
    use Prototype;
    public $name;
    public $message;

    public static function create($name, $message)
    {
        $instance = static::instantiate();
        $instance->name = $name;
        $instance->message = $message;
        return $instance;
    }

    public function toData()
    {
        return $this->prototype()->propertys()->values();
    }
}
