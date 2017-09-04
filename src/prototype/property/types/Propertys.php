<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/22
 * Time: 11:08
 */

namespace luhaoz\cpl\prototype\property\types;

use luhaoz\cpl\prototype\GeneralObject;

class Propertys extends Value
{

    public $properties;
    protected $_propertyInstance;

    protected function propertyInstance()
    {
        if ($this->_propertyInstance === null) {
            $this->_propertyInstance = new GeneralObject();
            $this->_propertyInstance->prototype()->properties()->configs($this->properties);
        }
        return $this->_propertyInstance;
    }

    public function set($value)
    {
        $this->propertyInstance()->prototype()->properties()->values($value);
        return $this;
    }

    public function get()
    {
        return $this->propertyInstance();
    }

    public function toData()
    {
        return $this->propertyInstance()->prototype()->properties()->values();
    }
}