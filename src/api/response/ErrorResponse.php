<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/5/17
 * Time: 12:00
 */

namespace luhaoz\cpl\api\response;

use luhaoz\cpl\api\base\BaseResponse;
use luhaoz\cpl\prototype\property\types\Value;

/**
 * Class ErrorResponse
 * @package luhaoz\cpl\api\response
 */
class ErrorResponse extends BaseResponse
{
    const RESPONSE_TYPE = 'error.list';

    public function properties()
    {
        return [
            'request_id' => [Value::class],
            'errors'     => [Value::class],
        ];
    }
}