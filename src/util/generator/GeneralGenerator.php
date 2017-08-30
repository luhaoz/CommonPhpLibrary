<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 10:08
 */

namespace luhaoz\cpl\util\generator;

use luhaoz\cpl\util\generator\base\BaseGenerator;


/**
 * Class GeneralGenerator
 * @package luhaoz\cpl\util\generator
 */
class GeneralGenerator extends BaseGenerator
{
    public $generate = null;

    public function generate($_ = null)
    {
        $params = func_get_args();
        return call_user_func_array($this->generate, $params);
    }
}