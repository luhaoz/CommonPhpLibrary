<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 10:08
 */

namespace luhaoz\cpl\prototype\plugin\base;

use luhaoz\cpl\prototype\plugin\interfaces\Plugin;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class BasePlugin
 * @package luhaoz\cpl\prototype\plugin\base
 */
class BasePlugin implements Plugin
{
    use Prototype;
    protected $_owner = null;
    protected $_config = null;
    const PLUGIN_NAME = '';
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

    public function install($config = [])
    {
        if (array_key_exists('propertys', $config)) {
            foreach ($config['propertys'] as $pluginPropertyName => $property) {
                $pluginProperty = $this->prototype()->propertys()->property($pluginPropertyName);
                $this->owner()->prototype()->propertys()->config($property, Dependence::dependenceMapper(\luhaoz\cpl\prototype\property\types\Junctor::class, [
                    '::junctorInstance' => [$pluginProperty],
                ]));
            }
        }

        if (array_key_exists('methods', $config)) {
            foreach ($config['methods'] as $pluginMethodName => $method) {
                $pluginMethod = $this->prototype()->methods()->method($pluginMethodName);
                $this->owner()->prototype()->methods()->config($method, Dependence::dependenceMapper(\luhaoz\cpl\prototype\method\types\Junctor::class, [
                    '::junctorInstance' => [$pluginMethod],
                ]));
            }
        }
        $this->initialise();
    }

    public function initialise()
    {
        // TODO: Implement initialise() method.
    }
}