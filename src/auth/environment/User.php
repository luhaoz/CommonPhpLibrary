<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/9
 * Time: 14:34
 */

namespace luhaoz\cpl\environment\auth\environment;


use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\environment\auth\Authenticator;
use luhaoz\cpl\environment\base\BaseEnvironment;
use luhaoz\cpl\prototype\property\types\Value;

/**
 * Class User
 * @package luhaoz\cpl\environment\auth\environment
 */
class User extends BaseEnvironment
{
    protected $_isGuest = true;

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs(array_merge([
            'id' => Dependence::dependenceConfig(Value::class),
        ], $this->properties()));
    }

    protected function properties()
    {
        return [];
    }

    public function get()
    {
        return $this;
    }

    public function set($value)
    {
        return $this->prototype()->properties()->values($value);
    }

    public function isGuest($isGuest = null)
    {
        if ($isGuest !== null) {
            $this->_isGuest = $isGuest;
        }
        return $this->_isGuest;
    }

    public function auth(Authenticator $authenticator)
    {
        $valid = $authenticator->valid();
        if ($valid) {
            $this->isGuest(false);
            $this->prototype()->properties()->values($authenticator->info());
            $this->id = $authenticator->getId();
        }
        return $valid;
    }
}