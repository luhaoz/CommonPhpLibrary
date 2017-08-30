<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 10:08
 */

namespace luhaoz\cpl\prototype\plugin\base;

use luhaoz\cpl\prototype\plugin\interfaces\Plugin;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class BasePlugin
 * @package luhaoz\cpl\prototype\plugin\base
 */
class GeneralPlugin extends BasePlugin
{
    public $initialise;

    public function initialise()
    {
        return call_user_func($this->initialise, $this);
    }
}