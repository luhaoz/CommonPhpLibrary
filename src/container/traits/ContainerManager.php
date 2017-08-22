<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/29
 * Time: 16:53
 */

namespace luhaoz\cpl\container\traits;


trait ContainerManager
{
    protected $_containerManager = null;

    public function containerManager()
    {
        if ($this->_containerManager === null) {
            $this->_containerManager = new \luhaoz\cpl\container\ContainerManager();
            $containerMapper = $this->containerMapper();
            $this->_containerManager->containerConfigs($containerMapper);
        }
        return $this->_containerManager;
    }

    public function containerMapper()
    {
        return [];
    }
}