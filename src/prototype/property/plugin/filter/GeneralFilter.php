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

class GeneralFilter extends BaseFilter
{
    public $validFilter = null;

    public function validFilter($property)
    {
        if ($property instanceof Value) {
            return call_user_func($this->validFilter, $property);
        }
        return false;
    }
}