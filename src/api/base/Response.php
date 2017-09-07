<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/25
 * Time: 18:09
 */

namespace luhaoz\cpl\api\base;

use luhaoz\cpl\dependence\Dependence;
use luhaoz\cpl\prototype\plugin\base\BasePlugin;

class Response extends BasePlugin
{
    public $model = null;
    protected $_model = null;

    /**
     * @param null $model
     *
     * @return BaseResponse;
     */
    public function model($model = null)
    {
        if ($model !== null) {
            $this->_model = $model;
        }

        if ($this->_model === null) {
            $this->_model = Dependence::instantiate($this->model);
        }

        return $this->_model;
    }

    public function toData()
    {
        return $this->model()->toData();
    }

    public function _constructed(\luhaoz\cpl\prototype\Prototype $prototype)
    {
        $prototype->properties($this->model()->prototype()->properties());
    }
}