<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/3
 * Time: 10:21
 */


namespace luhaoz\cpl\prototype;

use luhaoz\cpl\traits\BuildInstance;

/**
 * Class GeneralObject
 * @package luhaoz\cpl\prototype
 */
class GeneralObject
{
    use \luhaoz\cpl\prototype\traits\Prototype;
    use BuildInstance;
    public $constructed = null;

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        if ($this->constructed !== null) {
            call_user_func($this->constructed, $prototype);
        }
    }

}
