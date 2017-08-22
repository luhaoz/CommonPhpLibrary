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
            $this->_pluginPool->events()->on(DependencePool::EVENT_DEPENDENCE_INSTANTIATE, function (Plugin $plugin, $config) {
                $plugin->owner($this->owner());

            });
        }
        return $this->_pluginPool;
    }

    /**
     * @param $name
     * @return \luhaoz\cpl\prototype\plugin\traits\Plugin;
     */
    public function plugin($name)
    {
        return $this->pluginPool()->dependence($name);
    }

    public function config($pluginName, $config)
    {
        if (!$this->is($pluginName)) {
            $this->pluginPool()->config($pluginName, $config);
            if (array_key_exists('propertys', $config)) {
                foreach ($config['propertys'] as $pluginPropertyName => $property) {
                    $plugin = $this->plugin($pluginName);
                    $pluginProperty = $plugin->prototype()->propertys()->property($pluginPropertyName);
                    $this->owner()->prototype()->propertys()->config($property, Dependence::dependenceMapper(\luhaoz\cpl\prototype\property\types\Junctor::class, [
                        '::junctorInstance' => [$pluginProperty],
                    ]));
                }
            }

            if (array_key_exists('methods', $config)) {
                foreach ($config['methods'] as $pluginMethodName => $method) {
                    $plugin = $this->plugin($pluginName);
                    $pluginMethod = $plugin->prototype()->methods()->method($pluginMethodName);
                    $this->owner()->prototype()->methods()->config($method, Dependence::dependenceMapper(\luhaoz\cpl\prototype\method\types\Junctor::class, [
                        '::junctorInstance' => [$pluginMethod],
                    ]));
                }
            }
        }
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