<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/29
 * Time: 15:52
 */

namespace luhaoz\cpl\prototype\property\plugin\filter\base;

use luhaoz\cpl\prototype\property\base\BaseProperty;
use luhaoz\cpl\prototype\property\PropertyManager;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\BuildInstance;

class BaseFilter
{
    use Prototype;
    use BuildInstance;

    protected $_source;

    /**
     * @param null $source
     * @return PropertyManager
     */
    public function source($source = null)
    {
        if ($source !== null) {
            $this->_source = $source;
        }
        return $this->_source;
    }

    public function values($values = null)
    {
        $this->source()->values($values);
        return $this->filterValues();
    }

    protected function filterValues()
    {
        $values = [];
        foreach ($this->source()->memberIterator() as $propertyName => $property) {
            if ($this->validFilter($property)) {
                $values[$propertyName] = $property->toData();
            }
        }
        return $values;
    }

    protected function validFilter($property)
    {
        return $property instanceof BaseProperty;
    }
}