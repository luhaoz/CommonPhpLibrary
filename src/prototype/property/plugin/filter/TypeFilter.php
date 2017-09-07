<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/29
 * Time: 16:19
 */

namespace luhaoz\cpl\prototype\property\plugin\filter;

use luhaoz\cpl\prototype\property\plugin\filter\base\BaseFilter;
use luhaoz\cpl\prototype\property\types\Value;

class TypeFilter extends BaseFilter
{
    public $filter = [];

    public function validFilter($property)
    {
        if ($property instanceof Value) {
            $propertyName = $property->prototype()->reflection()->name;
            if (array_key_exists($propertyName, $this->filter)) {
                return $this->filter[$propertyName];
            } else {
                if (array_key_exists('_other', $this->filter)) {
                    return $this->filter['_other'];
                } else {
                    return true;
                }
            }
        }
        return false;
    }
}