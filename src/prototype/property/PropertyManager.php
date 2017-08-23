<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\prototype\property;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\prototype\method\types\Call;
use luhaoz\cpl\prototype\property\base\BaseProperty;
use luhaoz\cpl\prototype\property\types\Native;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class PropertyManager
 * @package luhaoz\cpl\prototype\property
 */
class PropertyManager implements \IteratorAggregate
{
    use Prototype;
    protected $_propertyPool = null;
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

    /**
     * @return DependencePool
     */
    public function propertyPool()
    {
        if ($this->_propertyPool === null) {
            $this->_propertyPool = new DependencePool();
            $this->_propertyPool->events()->on(DependencePool::EVENT_DEPENDENCE_CONFIG, function ($config) {
                $config['__hook.instantiate'] = function (BaseProperty $instance) use ($config) {
                    $instance->owner($this->owner());
                    $instance->name = $config['dependence_name'];
                    $instance->meta = $config;
                    if ($this->prototype()->pubSubs()->has('propertyInstantiate')) {
                        $this->prototype()->pubSubs()->emit('propertyInstantiate', [$instance]);
                    }
                };
                return $config;
            });

            $publicNatives = $this->owner()->prototype()->reflection()->getProperties(\ReflectionProperty::IS_PUBLIC);
            if (!empty($publicNatives)) {
                foreach ($publicNatives as $publicNative) {
                    $this->_propertyPool->config($publicNative->getName(), Dependence::dependenceMapper(Native::class, [
                        '::nativeInstance' => [$publicNative],
                    ]));
                }
            }
        }
        return $this->_propertyPool;
    }

    /**
     * @param $name
     * @return Value
     */
    public function property($name)
    {
        return $this->propertyPool()->dependence($name);
    }

    public function config($propertyName, $config)
    {
        $this->propertyPool()->config($propertyName, $config);
        return $this;
    }

    public function configs($propertyConfigs)
    {
        foreach ($propertyConfigs as $propertyName => $propertyConfig) {
            $this->config($propertyName, $propertyConfig);
        }
        return $this;
    }

    public function is($name)
    {
        return $this->propertyPool()->is($name);
    }

    public function values($values = null)
    {
        if (!empty($values)) {
            foreach ($values as $propertyName => $propertyValue) {
                if ($this->is($propertyName)) {
                    $this->property($propertyName)->set($propertyValue);
                }
            }
        }
        $values = [];
        foreach ($this->propertysIterator() as $propertyName => $property) {
            if ($property instanceof BaseProperty) {
                $values[$propertyName] = $property->toData();
            }
        }
        return $values;
    }

    /**
     * @return BaseProperty[]
     */
    public function propertysIterator()
    {
        foreach ($this->propertyPool()->dependencesIterator() as $propertyName => $property) {
            yield $propertyName => $property;
        }
    }

    public function getIterator()
    {
        return $this->propertysIterator();
    }
}