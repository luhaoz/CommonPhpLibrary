<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\environment;

use luhaoz\cpl\prototype\traits\Prototype;

class EnvironmentManager
{
    use Prototype;

    public $environments = null;

    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs($this->environments);
    }

    public function environment($environmentName)
    {
        return $this->prototype()->properties()->property($environmentName);
    }
}