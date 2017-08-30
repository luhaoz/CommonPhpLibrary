<?php
/**
 * Created by PhpStorm.
 * User: YM-PC
 * Date: 2017/4/21
 * Time: 16:30
 */

namespace luhaoz\cpl\util;

class Arrays
{
    public static function merge(array $array1, array $array2 = null, array $_ = null)
    {
        $configs = func_get_args();
        $currentConfig = array_shift($configs);
        foreach ($configs as $config) {
            foreach ($config as $configKey => $configValue) {
                if (array_key_exists($configKey, $currentConfig)) {
                    if (is_array($configValue)) {
                        if (is_array($currentConfig[$configKey])) {
                            $currentConfig[$configKey] = static::merge($currentConfig[$configKey], $configValue);
                        } else {
                            $currentConfig[$configKey] = $configValue;
                        }
                    } else {
                        $currentConfig[$configKey] = $configValue;
                    }
                } else {
                    $currentConfig[$configKey] = $configValue;
                }
            }
        }
        return $currentConfig;
    }
}