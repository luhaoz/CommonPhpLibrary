<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/4
 * Time: 17:20
 */

namespace luhaoz\cpl\reflection;

use Minime\Annotations\Reader;

class ReflectionClass extends \ReflectionClass
{
    protected $_annotations = null;

    /**
     * @return \Minime\Annotations\Interfaces\AnnotationsBagInterface
     */
    public function getAnnotations()
    {
        if ($this->_annotations === null) {
            $this->_annotations = Reader::createFromDefaults()->getAnnotations($this);
        }
        return $this->_annotations;
    }

    public function getProperty($name)
    {
        return new ReflectionProperty($this->name, $name);
    }

    public function getProperties($filter = NULL)
    {
        if ($filter === null) {
            $getProperties = parent::getProperties();
        } else {
            $getProperties = parent::getProperties($filter);
        }
        $properties = [];
        foreach ($getProperties as $propertyIndex => $property) {
            $properties[$propertyIndex] = new ReflectionProperty($this->name, $property->name);
        }
        return $properties;
    }

    public function getMethod($name)
    {
        return new ReflectionMethod($this->name, $name);
    }

    public function getMethods($filter = null)
    {
        if ($filter === null) {
            $getMethods = parent::getMethods();
        } else {
            $getMethods = parent::getMethods($filter);
        }
        $methods = [];
        foreach ($getMethods as $methodIndex => $method) {
            $methods[$methodIndex] = new ReflectionMethod($this->name, $method->name);
        }
        return $methods;
    }
}