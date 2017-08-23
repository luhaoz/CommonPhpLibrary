<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/3
 * Time: 10:21
 */


namespace luhaoz\cpl\prototype\traits;

use luhaoz\cpl\dependence\Dependence;

/**
 * Trait Prototype
 * @package luhaoz\cpl\prototype\traits
 */
trait Prototype
{
    protected $_prototype = null;

    /**
     * @return \luhaoz\cpl\prototype\Prototype
     */
    public function prototype()
    {
        if ($this->_prototype === null) {
            $this->_prototype = Dependence::instantiate(Dependence::dependenceMapper(\luhaoz\cpl\prototype\Prototype::class, [
                '::owner' => [$this],
            ]));

            $prototype = $this->_constructed($this->_prototype);
            if ($prototype !== null) {
                $this->_prototype = $prototype;
            }
        }
        return $this->_prototype;
    }

    /**
     * @return \luhaoz\cpl\prototype\Prototype;
     */
    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        return $prototype;
    }

    public function __set($name, $value)
    {
        return $this->prototype()->propertys()->property($name)->set($value);
    }

    public function __get($name)
    {
        return $this->prototype()->propertys()->property($name)->get();
    }

    public function __call($name, $arguments)
    {
        return $this->prototype()->methods()->method($name)->callArray($arguments);
    }

    public function __property_exists($name)
    {
        return $this->prototype()->propertys()->is($name);
    }

    public function __method_exists($name)
    {
        return $this->prototype()->methods()->is($name);
    }
}
