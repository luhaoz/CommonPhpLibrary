<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/29
 * Time: 16:53
 */

namespace luhaoz\cpl\container;

use luhaoz\cpl\dependence\DependencePool;

/**
 * Class ContainerManager
 * @package luhaoz\cpl\container
 */
class ContainerManager
{

    protected $_containerPool = null;
    const DEFAULT_CONTAINER = 'default.container';

    public function containerPool()
    {
        if ($this->_containerPool === null) {
            $this->_containerPool = new DependencePool();
        }
        return $this->_containerPool;
    }

    public function container($name = null)
    {
        if ($name === null) {
            $name = static::DEFAULT_CONTAINER;
        }
        return $this->containerPool()->dependence($name);
    }

    public function containerConfigs($configs)
    {
        return $this->containerPool()->configs($configs);
    }
}