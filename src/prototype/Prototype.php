<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/3
 * Time: 10:21
 */


namespace luhaoz\cpl\prototype;

use luhaoz\cpl\container\traits\ContainerManager;
use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\method\MethodManager;
use luhaoz\cpl\prototype\plugin\PluginManager;
use luhaoz\cpl\prototype\property\PropertyManager;

/**
 * Class Prototype
 * @package luhaoz\cpl\prototype
 */
class Prototype
{
    protected $_owner = null;
    protected $_reflection = null;

    use ContainerManager;
    public $dependenceMapper = [];

    public function containerMapper()
    {
        return array_merge([
            'property' => Dependence::dependenceMapper(PropertyManager::class, [
                '::owner' => [$this->owner()],
            ]),
            'method'   => Dependence::dependenceMapper(MethodManager::class, [
                '::owner' => [$this->owner()],
            ]),
            'plugin'   => Dependence::dependenceMapper(PluginManager::class, [
                '::owner' => [$this->owner()],
            ]),
        ], $this->dependenceMapper);
    }

    public function owner($owner = null)
    {
        if ($owner !== null) {
            $this->_owner = $owner;
        }
        return $this->_owner;
    }

    /**
     * @return \ReflectionClass
     */
    public function reflection()
    {
        if ($this->_reflection === null) {
            $this->_reflection = new \ReflectionClass(get_class($this->owner()));
        }
        return $this->_reflection;
    }

    /**
     * @return PropertyManager
     */
    public function propertys()
    {
        return $this->containerManager()->container('property');
    }

    /**
     * @return MethodManager
     */
    public function methods()
    {
        return $this->containerManager()->container('method');
    }

    /**
     * @return PluginManager
     */
    public function plugins()
    {
        return $this->containerManager()->container('plugin');
    }
}
