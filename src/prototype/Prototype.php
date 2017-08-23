<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/3
 * Time: 10:21
 */


namespace luhaoz\cpl\prototype;

use luhaoz\cpl\event\traits\Event;
use luhaoz\cpl\prototype\method\MethodManager;
use luhaoz\cpl\prototype\plugin\PluginManager;
use luhaoz\cpl\prototype\property\PropertyManager;
use luhaoz\cpl\pubsub\traits\PubSub;

/**
 * Class Prototype
 * @package luhaoz\cpl\prototype
 */
class Prototype
{
    use \luhaoz\cpl\prototype\traits\Prototype;
    use PubSub;
    use Event;
    protected $_owner = null;
    protected $_reflection = null;
    protected $_propertyManager = null;
    protected $_methodManager = null;
    protected $_pluginManager = null;

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
        if ($this->_propertyManager === null) {
            $this->_propertyManager = new PropertyManager();
            $this->_propertyManager->owner($this->owner());
        }
        return $this->_propertyManager;
    }

    /**
     * @return MethodManager
     */
    public function methods()
    {
        if ($this->_methodManager === null) {
            $this->_methodManager = new MethodManager();
            $this->_methodManager->owner($this->owner());
        }
        return $this->_methodManager;
    }

    /**
     * @return PluginManager
     */
    public function plugins()
    {
        if ($this->_pluginManager === null) {
            $this->_pluginManager = new PluginManager();
            $this->_pluginManager->owner($this->owner());
        }
        return $this->_pluginManager;
    }
}
