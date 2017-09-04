<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/9
 * Time: 17:13
 */

namespace luhaoz\cpl\dictionary\types;


use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\types\Value;

class Node extends Value
{
    public function get()
    {
        return $this;
    }

    public function toData()
    {
        return $this->prototypeGet();
    }

    public function initValue($values)
    {
        if (is_array($values)) {
            foreach ($values as $dictionaryName => $dictionary) {
                $this->prototype()->properties()->config($dictionaryName, Dependence::dependenceConfig(static::class, [
                    '::initValue' => [$dictionary],
                ]));
            }
        }
        $this->prototypeSet($values);

    }


    public function consult($name)
    {
        $dictionary = new static();
        if ($this->prototype()->properties()->is($name)) {
            $dictionary = $this->prototype()->properties()->property($name);
        }
        return $dictionary;
    }

    public function value()
    {
        return $this->toData();
    }

}