<?php

namespace luhaoz\cpl\prototype\plugin\interfaces;
/**
 * Interface Plugin
 * @package luhaoz\cpl\plugin\interfaces
 */
interface Plugin
{

    public function owner($owner = null);
    public function install($config = null);
}