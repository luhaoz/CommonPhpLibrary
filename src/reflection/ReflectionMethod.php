<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/4
 * Time: 17:20
 */

namespace luhaoz\cpl\reflection;

use Minime\Annotations\Reader;

class ReflectionMethod extends \ReflectionMethod
{
    protected $_annotations = null;

    /**
     * @return \Minime\Annotations\Interfaces\AnnotationsBagInterface
     */
    public function getAnnotations()
    {
        if ($this->_annotations === null) {
            $this->_annotations = Reader::createFromDefaults()->getMethodAnnotations($this->class, $this->name);
        }
        return $this->_annotations;
    }
}