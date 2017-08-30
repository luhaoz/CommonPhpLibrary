<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/7/5
 * Time: 10:04
 */

namespace luhaoz\cpl\environment\interfaces;

interface Authenticator
{
    public function valid();

    public function info();

    public function getId();
}