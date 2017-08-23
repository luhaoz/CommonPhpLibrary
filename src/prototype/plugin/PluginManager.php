<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\prototype\plugin;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\prototype\plugin\base\BasePlugin;
use luhaoz\cpl\prototype\plugin\interfaces\Plugin;
use luhaoz\cpl\prototype\traits\Prototype;


/**
 * Class PluginManager
 * @package luhaoz\cpl\prototype\plugin
 */
class PluginManager
{
    use Prototype;
    protected $_pluginPool = null;
    protected $_owner = null;

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


    public function pluginPool()
    {
        if ($this->_pluginPool === null) {
            $this->_pluginPool = new DependencePool();

            $this->_pluginPool->events()->on(DependencePool::EVENT_DEPENDENCE_CONFIG, function ($config) {
                $config['__hook.instantiate'] = function (Plugin $instance) use ($config) {
                    $instance->owner($this->owner());
                };
                return $config;
            });
        }
        return $this->_pluginPool;
    }

    /**
     * @param $name
     * @return BasePlugin
     */
    public function plugin($name)
    {
        return $this->pluginPool()->dependence($name);
    }

    public function setup($pluginName, $config)
    {
        $this->pluginPool()->config($pluginName, $config);
        $plugin = $this->plugin($pluginName);
        $plugin->install($config);
        return $this;
    }


    public function config($pluginName, $config)
    {
        $this->pluginPool()->config($pluginName, $config);
        return $this;
    }

    public function configs($pluginConfigs)
    {
        foreach ($pluginConfigs as $pluginName => $pluginConfig) {
            $this->config($pluginName, $pluginConfig);
        }
        return $this;
    }

    public function is($name)
    {
        return $this->pluginPool()->is($name);
    }

    public function pluginsIterator()
    {
        foreach ($this->pluginPool()->dependencesIterator() as $pluginName => $plugin) {
            yield $pluginName => $plugin;
        }
    }
}