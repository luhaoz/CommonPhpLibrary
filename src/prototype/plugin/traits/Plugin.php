<?php

namespace luhaoz\cpl\prototype\plugin\traits;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Interface Plugin
 * @package luhaoz\cpl\plugin\interfaces
 */
trait Plugin
{
    use Prototype;
    protected $_owner = null;
    protected $_config = null;

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

    public function config($config = null)
    {
        if ($config !== null) {
            $this->_config = $config;
        }
        return $this->_config;
    }



    public function initialise()
    {
        var_dump('q');
    }
}