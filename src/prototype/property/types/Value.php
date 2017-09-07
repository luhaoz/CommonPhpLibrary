<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\property\types;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\event\traits\Event;
use luhaoz\cpl\prototype\method\types\Method;
use luhaoz\cpl\prototype\property\base\BaseProperty;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\pubsub\traits\PubSub;
use PhpParser\Node\Expr\Closure;

/**
 * Class Value
 * @package luhaoz\cpl\prototype\property\types
 * @method isModify()
 * @method isEmpty()
 */
class Value extends BaseProperty
{
    use Prototype;
    use Event;
    use PubSub;

    public $constructed = null;

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs([
            'constructed' => Dependence::dependenceConfig(Initial::class, [
                'initial' => function ($value) use ($prototype) {
                    call_user_func($value, [$prototype]);
                },
            ]),
            'name'        => Dependence::dependenceConfig(BaseProperty::class),
            'meta'        => Dependence::dependenceConfig(BaseProperty::class),
            '__modfiy'    => Dependence::dependenceConfig(BaseProperty::class),
            'default'     => Dependence::dependenceConfig(BaseProperty::class),
        ]);
        $prototype->methods()->configs([
            'isEmpty'  => Dependence::dependenceConfig(Method::class, [
                '::method' => [function () {
                    return $this->_data === null;
                }],
            ]),
            'isModify' => Dependence::dependenceConfig(Method::class, [
                '::method' => [function () {
                    return $this->__modfiy == true;
                }],
            ]),
        ]);

        if ($this->constructed !== null) {
            call_user_func($this->constructed, [$prototype]);
        }
    }

    public function get()
    {
        if ($this->isEmpty()) {
            $default = $this->default;
            if ($default instanceof \Closure) {
                $default = call_user_func($default,$this);
            }
            $this->prototypeSet($default);
        }

        return $this->prototypeGet();
    }

    public function set($value)
    {
        $this->__modfiy = true;

        return $this->prototypeSet($value);
    }
}