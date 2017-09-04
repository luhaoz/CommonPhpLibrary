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
use luhaoz\cpl\prototype\base\BaseManager;
use luhaoz\cpl\prototype\method\types\Call;
use luhaoz\cpl\prototype\method\types\Method;
use luhaoz\cpl\prototype\property\base\BaseProperty;
use luhaoz\cpl\prototype\property\plugin\Filter;
use luhaoz\cpl\prototype\property\types\Native;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class PropertyManager
 * @package luhaoz\cpl\prototype\property
 * @method \luhaoz\cpl\prototype\property\plugin\filter\base\BaseFilter filter(\luhaoz\cpl\prototype\property\plugin\filter\base\BaseFilter $filter)
 * @method array values($values = null)
 * @method \Generator metas()
 */
class PropertyManager extends BaseManager implements \IteratorAggregate
{
    public function buildContainer()
    {
        $container = parent::buildContainer(); // TODO: Change the autogenerated stub
        $container->events()->on(DependencePool::EVENT_DEPENDENCE_CONFIG, function ($config) {
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
                $container->config($publicNative->getName(), Dependence::dependenceMapper(Native::class, [
                    '::nativeInstance' => [$publicNative],
                ]));
            }
        }

        return $container;
    }


    /**
     * @param $name
     * @return Value
     */
    public function property($name)
    {
        return $this->container()->dependence($name);
    }

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $this->prototype()->methods()->config('values', Dependence::dependenceMapper(Method::class, [
            '::method' => [function ($values = null) {
                if (!empty($values) && is_array($values)) {
                    foreach ($values as $propertyName => $propertyValue) {
                        if ($this->is($propertyName)) {
                            $this->property($propertyName)->set($propertyValue);
                        }
                    }
                }
                $values = [];
                foreach ($this->memberIterator() as $propertyName => $property) {
                    if ($property instanceof BaseProperty) {
                        $values[$propertyName] = $property->toData();
                    }
                }
                return $values;
            }],
        ]));

        $this->prototype()->methods()->config('metas', Dependence::dependenceMapper(Method::class, [
            '::method' => [function () {
                foreach ($this->memberIterator() as $propertyName => $property) {
                    yield $propertyName => $property->meta;
                }
            }],
        ]));
        $prototype->plugins()->setup(Filter::PLUGIN_NAME, Dependence::dependenceMapper(Filter::class));
    }

    /**
     * @return BaseProperty[]
     */
    public function memberIterator()
    {
        return parent::memberIterator(); // TODO: Change the autogenerated stub
    }

    public function getIterator()
    {
        return $this->memberIterator();
    }
}