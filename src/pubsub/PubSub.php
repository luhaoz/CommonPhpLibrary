<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/21
 * Time: 10:24
 */

namespace luhaoz\cpl\pubsub;

use luhaoz\cpl\pool\HashPool;
use Ramsey\Uuid\Uuid;

class PubSub
{
    protected $_pubSubPool = null;

    /***
     * @return HashPool
     */
    public function pubSubPool()
    {
        if ($this->_pubSubPool === null) {
            $this->_pubSubPool = new HashPool();
        }
        return $this->_pubSubPool;
    }


    public function emit($name, $parameter = [])
    {
        $subscribers = $this->pubSubPool()->get($name)->all();
        foreach ($subscribers as $subscriber) {
            call_user_func_array($subscriber, $parameter);
        }
    }

    public function has($name)
    {
        return $this->pubSubPool()->has($name);
    }

    public function on($name, $callBack)
    {
        if (!$this->pubSubPool()->has($name)) {
            $this->pubSubPool()->set($name, new HashPool());
        }
        $this->pubSubPool()->get($name)->set(Uuid::uuid4()->toString(), $callBack);
        return $this;
    }

}