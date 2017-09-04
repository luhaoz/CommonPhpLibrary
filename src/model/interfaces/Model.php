<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/4
 * Time: 16:03
 */

namespace luhaoz\cpl\model\interfaces;

interface Model
{
    public function find();

    public function findAll();

    public function findCount();

    public function findExist();

    public function search($search);

    public function source();

    public function create();

    public function update();

    public function save();

    public function delete();
}