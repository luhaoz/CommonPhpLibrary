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
use luhaoz\cpl\prototype\property\base\Hidden;
use luhaoz\cpl\pubsub\traits\PubSub;

class Initial extends Value implements \luhaoz\cpl\prototype\property\interfaces\Hidden
{
    public $initial = null;

    public function set($value)
    {
        if ($this->initial !== null) {
            call_user_func($this->initial, $value);
        }

        return parent::set($value);
    }

    public function toData()
    {
        return new Hidden();
    }
}