<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/30
 * Time: 9:30
 */

namespace luhaoz\cpl\prototype\base;

use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\event\traits\Event;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\pubsub\traits\PubSub;

class BaseManager
{
    use Prototype;
    use Event;
    use PubSub;
    protected $_owner = null;
    protected $_container = null;

    /**
     * @param null $owner
     * @return Prototype
     */
    public function owner($owner = null)
    {
        if ($owner !== null) {
            $this->_owner = $owner;
        }
        return $this->_owner;
    }

    /**
     * @return DependencePool
     */
    public function container()
    {
        if ($this->_container === null) {
            $this->_container = $this->buildContainer();
        }
        return $this->_container;
    }

    /**
     * @return DependencePool
     */
    protected function buildContainer()
    {
        $dependencePool = new DependencePool();
        return $dependencePool;
    }

    public function is($name)
    {
        return $this->container()->is($name);
    }

    public function config($configName, $config)
    {
        $this->container()->config($configName, $config);
        return $this;
    }

    public function configs($configs)
    {
        foreach ($configs as $configName => $config) {
            $this->config($configName, $config);
        }
        return $this;
    }

    public function memberIterator()
    {
        foreach ($this->container()->dependencesIterator() as $name => $item) {
            yield $name => $item;
        }
    }
}