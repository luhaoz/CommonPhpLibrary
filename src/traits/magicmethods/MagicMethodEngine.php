<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/1
 * Time: 10:47
 */

namespace app\common\component\traits\magicmethods;

use app\common\component\container\ContainerPool;
use app\common\component\container\traits\ContainerManager;
use app\common\component\dependence\Dependence;
use app\common\component\pool\DataPool;

/**
 * Class MagicMethodEngine
 * @package app\common\component\traits\magicmethods
 */
class MagicMethodEngine
{
    use ContainerManager;

    const MAGIC_METHOD_CALL = 'call';
    const MAGIC_METHOD_CALL_STATIC = 'callStatic';
    const MAGIC_METHOD_GET = 'get';
    const MAGIC_METHOD_SET = 'set';

    protected $_master = null;

    protected static $magicMethodNames = [];

    public function __construct()
    {

        static::$magicMethodNames = [
            static::MAGIC_METHOD_CALL,
            static::MAGIC_METHOD_CALL_STATIC,
            static::MAGIC_METHOD_GET,
            static::MAGIC_METHOD_SET,
        ];
    }

    public function master($master = null)
    {
        if (!empty($master)) {
            $this->_master = $master;
        }
        return $this->_master;
    }

    public function containerMapper()
    {
        return [
            ContainerPool::DEFAULT_CONTAINER_NAME => Dependence::dependenceMapper(DataPool::class),
        ];
    }

    /**
     * @param $method
     * @return MethodRun
     */
    public function method($method)
    {
        if (!$this->container()->has($method)) {
            $methodRun = new MethodRun();
            $this->container()->set($method, $methodRun);
        }
        $this->container()->get($method)->master($this->master());
        return $this->container()->get($method);
    }

    public function batch($magicMethods)
    {
        foreach ($magicMethods as $magicMethod => $runMethod) {
            if (in_array($magicMethod, static::$magicMethodNames)) {
                $this->method($magicMethod)->set($runMethod, $runMethod);
            }
        }
    }

}