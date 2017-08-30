<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\validate;

use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\prototype\base\BaseManager;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\validate\base\BaseValidator;


class ValidateManager extends BaseManager
{
    protected function buildContainer()
    {
        $buildContainer = parent::buildContainer();
        return $buildContainer;
    }


    /**
     * @param $data
     * @return ValidateResult
     */
    public function validate($data)
    {
        $validateResult = new ValidateResult();
        foreach ($this->memberIterator() as $validatorName => $validator) {
            $validator->name = $validatorName;
            if (!$validator->validate($data)) {
                $validateResult->errors()->add($validator->errors());
                $validateResult->valid(false);
            }
        }
        return $validateResult;
    }
}