<?php

/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/1
 * Time: 10:00
 */

namespace app\common\component\traits;

use app\common\component\traits\magicmethods\MagicMethodEngine;
use Minime\Annotations\Reader;

trait MagicMethods
{

    protected static $_annotationsReader = null;
    protected static $_instanceReflection = null;
    protected static $_magicMethodEngine = null;


    /**
     * @return Reader
     */
    protected static function _annotationsReader()
    {
        if (static::$_annotationsReader === null) {
            static::$_annotationsReader = \Minime\Annotations\Reader::createFromDefaults();
        }
        return static::$_annotationsReader;
    }

    /**
     * @return \ReflectionClass;
     */
    protected static function _instanceReflection()
    {
        if (static::$_instanceReflection === null) {
            static::$_instanceReflection = new \ReflectionClass(static::class);
        }
        return static::$_instanceReflection;
    }

    /**
     * @return MagicMethodEngine
     */
    protected static function _magicMethodEngine()
    {
        if (static::$_magicMethodEngine === null) {
            $magicMethodEngine = new MagicMethodEngine();
            $magicMethodEngine->master(static::class);
            $classAnnotation = static::_annotationsReader()->getClassAnnotations(static::class);
            $magicMethodEngine->batch($classAnnotation->toArray());

            $traits = static::_instanceReflection()->getTraits();
            if (!empty($traits)) {
                foreach ($traits as $trait) {
                    $annotation = static::_annotationsReader()->getClassAnnotations($trait->getName());
                    $magicMethodEngine->batch($annotation->toArray());
                }
            }

            static::$_magicMethodEngine = $magicMethodEngine;
        }
        return static::$_magicMethodEngine;
    }

    public static function __callStatic($name, $arguments)
    {
        $magicMethodEngine = static::_magicMethodEngine();
        return $magicMethodEngine->method(MagicMethodEngine::MAGIC_METHOD_CALL_STATIC)->run($name, $arguments);
    }

    public function __get($name)
    {
        $magicMethodEngine = static::_magicMethodEngine();
        $magicMethodEngine->master($this);
        return $magicMethodEngine->method(MagicMethodEngine::MAGIC_METHOD_GET)->run($name);
    }

}