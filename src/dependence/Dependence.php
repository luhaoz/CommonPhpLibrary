<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/29
 * Time: 17:03
 */

namespace luhaoz\cpl\dependence;

use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\reflection\ReflectionClass;

class Dependence
{

    const DEPENDENCE_CONFIG_CLASS_NAME_KEY = 'class';
    const DEPENDENCE_CONFIG_CLASS_NAME_INDEX = 0;
    const DEPENDENCE_INITIALIZE_METHOD = '__initialize';
    const DEPENDENCE_CONFIG_INITIALIZE_KEY = '__initialize';

    public static function dependenceConfig($class, $config = [])
    {
        $configMapper = [
            static::DEPENDENCE_CONFIG_CLASS_NAME_KEY => $class,
        ];
        if (!empty($config)) {
            $configMapper = array_merge($configMapper, $config);
        }
        return $configMapper;
    }

    public static function dependenceConfigValid($dependenceConfig)
    {

    }

    public static function getDependenceConfigClass($dependenceConfig)
    {
        if (array_key_exists(static::DEPENDENCE_CONFIG_CLASS_NAME_KEY, $dependenceConfig)) {
            $className = $dependenceConfig[static::DEPENDENCE_CONFIG_CLASS_NAME_KEY];
        } else {
            $className = $dependenceConfig[static::DEPENDENCE_CONFIG_CLASS_NAME_INDEX];
        }
        return $className;

    }

    public static function instantiate($dependenceConfig)
    {
        $dependenceClassName = static::getDependenceConfigClass($dependenceConfig);
        $reflection = new ReflectionClass($dependenceClassName);

        $instance = $reflection->newInstance();
        if (array_key_exists('__hook.instantiate', $dependenceConfig)) {
            call_user_func_array($dependenceConfig['__hook.instantiate'], [$instance]);
        }


        if ($reflection->hasMethod(static::DEPENDENCE_INITIALIZE_METHOD)) {
            call_user_func_array([$instance, static::DEPENDENCE_INITIALIZE_METHOD], [$dependenceConfig]);
        }
//
        if (array_key_exists(static::DEPENDENCE_CONFIG_INITIALIZE_KEY, $dependenceConfig) && $dependenceConfig[static::DEPENDENCE_CONFIG_INITIALIZE_KEY] instanceof \Closure) {
            call_user_func_array($dependenceConfig[static::DEPENDENCE_CONFIG_INITIALIZE_KEY], [$instance, $dependenceConfig]);
        }
//
        $continueList = [
            static::DEPENDENCE_CONFIG_INITIALIZE_KEY,
            static::DEPENDENCE_CONFIG_CLASS_NAME_KEY,
        ];

        foreach ($dependenceConfig as $dependenceInitAttribute => $dependenceInitValue) {
            if (in_array($dependenceInitAttribute, $continueList)) {
                continue;
            }

            if (strpos($dependenceInitAttribute, '::') !== false) {
                $method = str_replace('::', null, $dependenceInitAttribute);
                if ($reflection->hasMethod($method) && $reflection->getMethod($method)->isPublic()) {
                    $reflection->getMethod($method)->invokeArgs($instance, $dependenceInitValue);
                    continue;
                }

                if ($reflection->hasMethod('__method_exists') && $reflection->getMethod('__method_exists')->invokeArgs($instance, [$dependenceInitAttribute])) {
                    call_user_func_array([$instance, $method], $dependenceInitValue);
                    continue;
                }
            }

            if ($reflection->hasProperty($dependenceInitAttribute) && $reflection->getProperty($dependenceInitAttribute)->isPublic()) {
                $reflection->getProperty($dependenceInitAttribute)->setValue($instance, $dependenceInitValue);
                continue;
            }

            if ($reflection->hasMethod('__property_exists') && $reflection->getMethod('__property_exists')->invokeArgs($instance, [$dependenceInitAttribute])) {
                $instance->{$dependenceInitAttribute} = $dependenceInitValue;
                continue;
            }
        }

        return $instance;
    }
}