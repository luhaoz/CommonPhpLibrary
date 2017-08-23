<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\prototype\method;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\prototype\method\base\BaseMethod;
use luhaoz\cpl\prototype\method\types\Call;
use luhaoz\cpl\prototype\method\types\Native;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class MethodManager
 * @package luhaoz\cpl\prototype\method
 */
class MethodManager
{
    use Prototype;
    protected $_methodPool = null;
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


    public function methodPool()
    {
        if ($this->_methodPool === null) {
            $this->_methodPool = new DependencePool();

            $this->_methodPool->events()->on(DependencePool::EVENT_DEPENDENCE_CONFIG, function ($config) {
                $config['__hook.instantiate'] = function (BaseMethod $instance) use ($config) {
                    $instance->owner($this->owner());
                };
                return $config;
            });

            $publicNatives = $this->owner()->prototype()->reflection()->getMethods(\ReflectionMethod::IS_PUBLIC);
            if (!empty($publicNatives)) {
                foreach ($publicNatives as $publicNative) {
                    if (in_array($publicNative->getName(), ['__set', '__get', '__call', '__property_exists', '__method_exists', '_constructed', 'prototype'])) {
                        continue;
                    }
                    $this->_methodPool->config($publicNative->getName(), Dependence::dependenceMapper(Native::class, [
                        '::nativeInstance' => [$publicNative],
                    ]));
                }
            }
        }
        return $this->_methodPool;
    }

    /**
     * @param $name
     * @return Call
     */
    public function method($name)
    {
        return $this->methodPool()->dependence($name);
    }

    public function config($methodName, $config)
    {
        $this->methodPool()->config($methodName, $config);
        return $this;
    }

    public function configs($methodConfigs)
    {
        foreach ($methodConfigs as $methodName => $methodConfig) {
            $this->config($methodName, $methodName);
        }
        return $this;
    }

    public function is($name)
    {
        return $this->methodPool()->is($name);
    }

    public function methodsIterator()
    {
        foreach ($this->methodPool()->dependencesIterator() as $methodName => $method) {
            yield $methodName => $method;
        }
    }
}