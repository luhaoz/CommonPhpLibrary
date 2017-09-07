<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/3
 * Time: 10:21
 */


namespace luhaoz\cpl\prototype;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\types\Initial;
use luhaoz\cpl\traits\BuildInstance;

/**
 * Class GeneralObject
 * @package luhaoz\cpl\prototype
 */
class GeneralObject
{
    use \luhaoz\cpl\prototype\traits\Prototype;
    use BuildInstance;

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs([
            'constructed' => Dependence::dependenceConfig(Initial::class, [
                'initial' => function ($value) use ($prototype) {
                    call_user_func($value, [$prototype]);
                },
            ]),
        ]);
    }

}
