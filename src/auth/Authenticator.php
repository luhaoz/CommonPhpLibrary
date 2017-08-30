<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/7/5
 * Time: 10:04
 */

namespace luhaoz\cpl\environment\auth;


use luhaoz\cpl\traits\BuildInstance;

class Authenticator implements \luhaoz\cpl\environment\interfaces\Authenticator
{
    use BuildInstance;

    public function valid()
    {
        return true;
    }

    public function getId()
    {
        return false;
    }

    public function info()
    {
        return [];
    }
}