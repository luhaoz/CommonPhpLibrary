<?php

namespace luhaoz\cpl\pool\interfaces;

/**
 * Interface HashPool
 * @package luhaoz\cpl\pool\interfaces
 */
interface HashPool
{
    public function get($name);

    public function set($name, $value);

    public function del($name);

    public function clear();

    public function has($name);

    public function batch($batchs);

    public function all();
}