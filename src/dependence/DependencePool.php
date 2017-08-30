<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/29
 * Time: 16:53
 */

namespace luhaoz\cpl\dependence;

use luhaoz\cpl\event\traits\Event;
use luhaoz\cpl\pool\HashPool;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\pubsub\traits\PubSub;

class DependencePool
{
    use Event;
    use PubSub;
    const EVENT_DEPENDENCE_INSTANTIATE = 'dependence.instantiate';
    const EVENT_DEPENDENCE_CONFIG = 'dependence.config';


    protected $_dependencePool;
    protected $_dependenceConfigs;


    public function dependencePool()
    {
        if ($this->_dependencePool === null) {
            $this->_dependencePool = new HashPool();
        }
        return $this->_dependencePool;
    }


    public function dependenceConfigs()
    {
        if ($this->_dependenceConfigs === null) {
            $this->_dependenceConfigs = new HashPool();
        }
        return $this->_dependenceConfigs;
    }

    public function config($name, $config = null)
    {
        if (!empty($config)) {
            return $this->dependenceConfigs()->set($name, $config);
        }
        return $this->dependenceConfigs()->get($name);
    }

    public function configs($configs = null)
    {
        if ($configs !== null) {
            $this->dependenceConfigs()->batch($configs);
        }
        return $this->dependenceConfigs()->all();
    }

    public function configNames()
    {
        return array_keys($this->configs());
    }

    public function dependence($name)
    {
        if (!$this->dependencePool()->has($name)) {
            if ($this->is($name)) {
                $config = $this->config($name);
                $config['dependence_name'] = $name;
                if ($this->events()->has(static::EVENT_DEPENDENCE_CONFIG)) {
                    $config = $this->events()->trigger(static::EVENT_DEPENDENCE_CONFIG, [$config]);
                }
                $instance = Dependence::instantiate($config);
                $this->events()->trigger(static::EVENT_DEPENDENCE_INSTANTIATE, [$instance, $config]);
                $this->dependencePool()->set($name, $instance);
            } else {
                throw new \Exception('Dependence : ' . $name . ' non-existent');
            }

        }
        return $this->dependencePool()->get($name);
    }

    public function is($name)
    {
        return $this->dependenceConfigs()->has($name);
    }

    public function dependencesIterator()
    {
        foreach ($this->configNames() as $configName) {
            yield $configName => $this->dependence($configName);
        }
    }

    public function dependences()
    {
        $dependences = [];
        foreach ($this->dependencesIterator() as $dependenceName => $dependence) {
            if ($dependence instanceof \luhaoz\cpl\dependence\interfaces\Dependence) {
                $dependences[$dependenceName] = $dependence;
            }
        }
        return $dependences;
    }
}