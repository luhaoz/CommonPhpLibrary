<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/29
 * Time: 17:50
 */

namespace luhaoz\cpl\util;

use luhaoz\cpl\dependence\Dependence;

use luhaoz\cpl\prototype\plugin\base\BasePlugin;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\StaticInstance;
use luhaoz\cpl\util\generator\GeneralGenerator;
use Ramsey\Uuid\Uuid;

class Generator extends BasePlugin
{
    const PLUGIN_NAME = 'generator';
    use StaticInstance;

    protected $_generators = [];

    public function generators()
    {
        return array_merge([
            'time'        => Dependence::dependenceConfig(GeneralGenerator::class, [
                'generate' => function () {
                    return time();
                },
            ]),
            'date'        => Dependence::dependenceConfig(GeneralGenerator::class, [
                'generate' => function ($formate = 'Y-m-d H:i:s') {
                    return date($formate, time());
                },
            ]),
            'microtime'   => Dependence::dependenceConfig(GeneralGenerator::class, [
                'generate' => function () {
                    return microtime(true);
                },
            ]),
            'uuid'        => Dependence::dependenceConfig(GeneralGenerator::class, [
                'generate' => function () {
                    return Uuid::uuid4()->toString();
                },
            ]),
            'primary_key' => Dependence::dependenceConfig(GeneralGenerator::class, [
                'generate' => function () {
                    return strtoupper(md5(Uuid::uuid4()->toString() . '_' . rand(1, rand(1, 1000)) . '_' . microtime(true)));
                },
            ]),
        ], $this->_generators);
    }

    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $this->prototype()->plugins()->setups($this->generators());
    }

    public function generate($generateName, $_ = null)
    {
        $params = func_get_args();
        array_shift($params);
        return call_user_func_array([$this->prototype()->plugins()->plugin($generateName), 'generate'], $params);
    }

    public function config($name, $config)
    {
        return $this->prototype()->plugins()->setup($name, $config);
    }

    public function configs($configs)
    {
        foreach ($configs as $configName => $config) {
            $this->config($configName, $config);
        }
    }
}