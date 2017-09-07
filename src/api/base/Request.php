<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/25
 * Time: 18:09
 */

namespace luhaoz\cpl\api\base;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\plugin\base\BasePlugin;
use luhaoz\cpl\prototype\property\types\Initial;

class Request extends BasePlugin
{
    protected $_params = [];

    public function params($params = null)
    {
        if ($params !== null) {
            $this->_params = $params;
            $this->prototype()->properties()->values($params);
        }

        return $this->_params;
    }

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs([
            'parameters' => Dependence::dependenceConfig(Initial::class, [
                'initial' => function ($value) use ($prototype) {
                    $prototype->properties()->configs($value);
                },
            ]),
        ]);
    }
}