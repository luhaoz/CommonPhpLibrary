<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/3
 * Time: 10:21
 */


namespace luhaoz\cpl\api\response;

use luhaoz\cpl\api\base\BaseResponse;
use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\property\plugin\filter\GeneralFilter;

class GeneralResponse extends BaseResponse
{

    public $properties = [];
    public $constructed = null;

    protected function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        parent::_constructed($prototype);
        if ($this->constructed !== null) {
            call_user_func($this->constructed, $prototype);
        }
    }

    public function properties()
    {
        return $this->properties;
    }

    public function toData()
    {
        return $this->prototype()->properties()
            ->filter(Dependence::instantiate(Dependence::dependenceConfig(GeneralFilter::class, [
                'validFilter' => function ($propertie) {
                    return in_array($propertie->name, ['properties', 'constructed']) == false;
                },
            ])))
            ->values();
    }
}
