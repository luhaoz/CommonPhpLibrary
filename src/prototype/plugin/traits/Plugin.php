<?php

namespace luhaoz\cpl\prototype\plugin\traits;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Interface Plugin
 * @package luhaoz\cpl\plugin\interfaces
 */
trait Plugin
{
    use Prototype;
    protected $_owner = null;

    public function owner($owner = null)
    {
        if ($owner !== null) {
            $this->_owner = $owner;
        }
        return $this->_owner;
    }
}