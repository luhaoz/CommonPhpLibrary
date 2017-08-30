<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/5/17
 * Time: 12:00
 */

namespace luhaoz\cpl\api\request;

use luhaoz\cpl\api\base\BaseRequest;
use luhaoz\cpl\prototype\property\types\Value;

class SetsRequest extends BaseRequest
{

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->propertys()->configs([
            'page'       => [Value::class, 'default' => 1],
            'page_count' => [Value::class, 'default' => 10],
        ]);
    }
}