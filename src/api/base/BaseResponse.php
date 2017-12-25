<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/5/17
 * Time: 12:00
 */

namespace luhaoz\cpl\api\base;

use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\traits\BuildInstance;

/**
 * Class BaseResponse
 * @package luhaoz\cpl\api\base
 */
class BaseResponse
{
    use Prototype;
    use BuildInstance;
    const RESPONSE_TYPE = '';
    public $type = null;
    public $code = 200;


    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {

        $this->type = static::RESPONSE_TYPE;
        $prototype->properties()->configs(array_merge([], $this->properties()));
    }

    public function properties()
    {
        return [];
    }

    public function toData()
    {
        return $this->prototype()->properties()->values();
    }
}