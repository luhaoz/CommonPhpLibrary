<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/18
 * Time: 13:02
 */

namespace luhaoz\cpl\util;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\behavior\types\Behavior;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\StaticInstance;

/**
 * Class Util
 * @package luhaoz\cpl\traits
 * @property \luhaoz\cpl\util\Generator $generator ge
 */
class Util
{
    use StaticInstance;
    use Prototype;

    public $utils = [];

    protected function utils()
    {
        return array_merge([
            Generator::PLUGIN_NAME => Dependence::dependenceMapper(Generator::class),
        ], $this->utils);
    }

    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $this->prototype()->plugins()->setups($this->utils());
        $this->prototype()->behaviors()->config('__get', Dependence::dependenceMapper(Behavior::class, [
            'behavior' => function ($name) {
                return $this->prototype()->plugins()->plugin($name);
            },
        ]));
    }

    public static function app()
    {
        return static::instance();
    }


}