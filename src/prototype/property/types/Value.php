<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\property\types;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\base\BaseProperty;
use luhaoz\cpl\prototype\traits\Prototype;

class Value extends BaseProperty
{
    use Prototype;

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->propertys()->configs([
            'name' => Dependence::dependenceMapper(BaseProperty::class),
            'meta' => Dependence::dependenceMapper(BaseProperty::class),
        ]);
    }
}