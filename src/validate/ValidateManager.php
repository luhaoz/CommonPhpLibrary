<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/6/30
 * Time: 15:19
 */

namespace luhaoz\cpl\validate;

use luhaoz\cpl\dependence\DependencePool;
use luhaoz\cpl\error\traits\ErrorManager;
use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\validate\base\BaseValidator;


class ValidateManager
{
    use Prototype;
    protected $_validatorPool = null;

    public function validatorPool()
    {
        if ($this->_validatorPool === null) {
            $this->_validatorPool = new DependencePool();
            $this->_validatorPool->events()->on(DependencePool::EVENT_DEPENDENCE_INSTANTIATE, function ($property, $config) {

            });
        }
        return $this->_validatorPool;
    }

    public function config($validateName, $config)
    {
        $this->validatorPool()->config($validateName, $config);
        return $this;
    }

    public function configs($validates)
    {
        foreach ($validates as $validateName => $validate) {
            $this->config($validateName, $validate);
        }
        return $this;
    }

    /**
     * @return BaseValidator[]
     */
    public function validatorsIterator()
    {
        foreach ($this->validatorPool()->dependencesIterator() as $validatorName => $validator) {
            yield $validatorName => $validator;
        }
    }

    /**
     * @param $data
     * @return ValidateResult
     */
    public function validate($data)
    {
        $validateResult = new ValidateResult();
        foreach ($this->validatorsIterator() as $validatorName => $validator) {
            $validator->name = $validatorName;
            if (!$validator->validate($data)) {
                $validateResult->errors()->add($validator->errors());
                $validateResult->valid(false);
            }
        }
        return $validateResult;
    }
}