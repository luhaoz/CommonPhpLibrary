<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/25
 * Time: 18:00
 */

namespace luhaoz\cpl\api\base;

use luhaoz\cpl\api\plugin\ApiDoc;
use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\StaticInstance;
use luhaoz\cpl\util\Arrays;

/**
 * Class ApiDriver
 * @package luhaoz\cpl\api\base
 * @property string $method
 * @property string $endpoint
 */
class ApiDriver
{
    use Prototype;
    use StaticInstance;
    const META_REQUEST = 'request';
    const META_RESPONSE = 'response';

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties()->configs([
            'method'   => Dependence::dependenceConfig(Value::class),
            'endpoint' => Dependence::dependenceConfig(Value::class),
        ]);
        $prototype->plugins()->setups($this->_config());
        $prototype->plugins()->setup(ApiDoc::PLUGIN_NAME, Dependence::dependenceConfig(ApiDoc::class));

    }

    protected function _config()
    {
        return Arrays::merge([
            static::META_REQUEST  => Dependence::dependenceConfig(Request::class, [
                'parameter' => [],
            ]),
            static::META_RESPONSE => Dependence::dependenceConfig(Response::class, [
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