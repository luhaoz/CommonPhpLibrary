<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/5/17
 * Time: 12:00
 */

namespace luhaoz\cpl\api\response;

use luhaoz\cpl\api\base\BaseResponse;
use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\error\ErrorManager;
use luhaoz\cpl\prototype\property\types\Value;
use luhaoz\cpl\util\Util;

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
            'request_id' => Dependence::dependenceConfig(Value::class),
            'errors'     => Dependence::dependenceConfig(Value::class),
        ];
    }

    public function errors($errors)
    {
        $errorDatas = [];
        if ($errors instanceof ErrorManager) {
            foreach ($errors->errrosIterator() as $error) {
                $errorDatas[] = $error->toData();
            }
        }
        $this->errors = $errorDatas;
    }
}