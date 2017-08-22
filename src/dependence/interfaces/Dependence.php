<?php

namespace luhaoz\cpl\dependence\interfaces;

use luhaoz\cpl\pool\interfaces\HashPool;


/**
 * Interface DependencePool
 * @package luhaoz\cpl\dependence\interfaces
 */
interface Dependence
{
    public function dependenceName($dependenceName);
}