<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/25
 * Time: 18:09
 */

namespace luhaoz\cpl\api\base;

use luhaoz\cpl\prototype\plugin\base\BasePlugin;

class Request extends BasePlugin
{
    public $parameter = [];

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs($this->parameter);
    }
}