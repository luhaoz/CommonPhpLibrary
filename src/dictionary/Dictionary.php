<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/9
 * Time: 17:13
 */

namespace luhaoz\cpl\dictionary;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\dictionary\types\Node;
use luhaoz\cpl\prototype\traits\Prototype;

class Dictionary
{

    use Prototype;

    public function __construct($dictionaryConfig = null)
    {
        if (!empty($dictionaryConfig)) {
            $this->import($dictionaryConfig);
        }
    }

    public function import($dictionaryConfig)
    {
        foreach ($dictionaryConfig as $dictionaryName => $dictionary) {
            $this->prototype()->properties()->config($dictionaryName, Dependence::dependenceConfig(Node::class, [
                '::initValue' => [$dictionary],
            ]));
        }
    }

    public function consult($name)
    {
        $dictionary = new Node();
        if ($this->prototype()->properties()->is($name)) {
            $dictionary = $this->prototype()->properties()->property($name);
        }
        return $dictionary;
    }
}