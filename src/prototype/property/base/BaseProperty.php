<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\prototype\property\base;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class BaseProperty
 * @package luhaoz\cpl\prototype\property\base
 * @property string $name  property meta
 * @property string $meta property meta
 */
class BaseProperty
{
    protected $_data;

    protected $_owner = null;

    public function owner($owner = null)
    {
        if ($owner !== null) {
            $this->_owner = $owner;
        }
        return $this->_owner;
    }

    public function get()
    {
        return $this->prototypeGet();
    }

    public function set($value)
    {
        return $this->prototypeSet($value);
    }

    public function prototypeSet($value)
    {
        return $this->_data = $value;
    }

    public function prototypeGet()
    {
        return $this->_data;
    }

    public function toData()
    {
        return $this->get();
    }

}