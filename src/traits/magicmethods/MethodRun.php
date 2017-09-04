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

;

class MethodRun
{
    use ContainerManager;
    protected $_master = null;

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
            ContainerPool::DEFAULT_CONTAINER_NAME => Dependence::dependenceConfig(DataPool::class),
        ];
    }

    public function set($name, $method)
    {
        return $this->container()->set($name, $method);
    }

    public function run($name, $arguments = null)
    {
        $methods = $this->container()->all();
        foreach ($methods as $method) {
            $return = call_user_func_array([$this->master(), $method], [$name, $arguments]);
            if (!$return instanceof ContinueRun) {
                return $return;
            }
        }
    }
}