<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/4
 * Time: 16:13
 */

namespace luhaoz\cpl\model\base;

use luhaoz\cpl\model\interfaces\Model;
use luhaoz\cpl\prototype\traits\Prototype;

/**
 * Class BaseModel
 * @package luhaoz\cpl\model\base
 */
class BaseModel implements Model
{
    use Prototype;

    public function find()
    {
        // TODO: Implement find() method.
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findCount()
    {
        // TODO: Implement findCount() method.
    }

    public function findExist()
    {
        // TODO: Implement findExist() method.
    }

    public function search($search)
    {
        // TODO: Implement search() method.
    }

    public function source()
    {
        // TODO: Implement source() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}