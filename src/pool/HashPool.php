<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/29
 * Time: 16:53
 */

namespace luhaoz\cpl\pool;

use luhaoz\cpl\traits\StaticInstance;

class HashPool implements \luhaoz\cpl\pool\interfaces\HashPool, \IteratorAggregate
{
    use StaticInstance;
    protected $_pool = [];

    public function __construct($datas = [])
    {
        if (!empty($datas)) {
            $this->batch($datas);
        }
    }

    public function batch($datas)
    {
        foreach ($datas as $dataKey => $dataValue) {
            $this->set($dataKey, $dataValue);
        }

        return $this;
    }

    public function set($key, $value)
    {
        return $this->_pool[$key] = $value;
    }

    public function get($key)
    {
        return $this->_pool[$key];
    }

    public function del($key)
    {
        $value = $this->get($key);
        unset($this->_pool[$key]);
        return $value;
    }

    public function clear()
    {
        $all = $this->all();
        $this->_pool = [];
        return $all;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->_pool);
    }

    public function all()
    {
        return $this->_pool;
    }

    public function keys()
    {
        return array_keys($this->_pool);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->all());
    }
}