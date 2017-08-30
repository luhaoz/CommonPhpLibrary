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

class NoEmptyFilter extends BaseFilter
{
    public function validFilter($property)
    {
        if ($property instanceof Value) {
            return !$property->isEmpty();
        }
        return false;
    }
}