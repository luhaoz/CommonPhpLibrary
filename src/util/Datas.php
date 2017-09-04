<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/4
 * Time: 17:39
 */

namespace luhaoz\cpl\util;

class Datas
{
    public static function toDatas($datas)
    {
        $toData = [];

        if ($datas instanceof \Iterator) {
            foreach ($datas as $dataName => $data) {
                $toData[$dataName] = $data;
            }
        }

        return $toData;
    }
}