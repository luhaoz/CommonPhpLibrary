<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/25
 * Time: 18:00
 */

namespace luhaoz\cpl\api\base;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\util\Arrays;

/**
 * Class ApiDriver
 * @package luhaoz\cpl\api\base
 */
class ApiDriver
{
    use Prototype;
    const META_REQUEST = 'request';
    const META_RESPONSE = 'response';

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->plugins()->setups($this->_config());

        $prototype->propertys()->config('method', Dependence::dependenceMapper(Value::class));
        $prototype->propertys()->config('endpoint', Dependence::dependenceMapper(Value::class));

    }

    protected function _config()
    {
        return Arrays::merge([
            static::META_REQUEST  => Dependence::dependenceMapper(Request::class, [
                'parameter' => [],
            ]),
            static::META_RESPONSE => Dependence::dependenceMapper(Response::class, [
                'parameter' => [],
            ]),
        ], $this->config());
    }

    public function config()
    {
        return [

        ];
    }

    /**
     * @return Request
     */
    public function request()
    {
        return $this->prototype()->plugins()->plugin(static::META_REQUEST);
    }

    /**
     * @return Response
     */
    public function response()
    {
        return $this->prototype()->plugins()->plugin(static::META_RESPONSE);
    }

    public function run()
    {
        throw new \Exception('Run is');
    }
}