<?php

namespace luhaoz\cpl\pubsub\traits;

trait PubSub
{
    protected $_pubSubs = null;

    /**
     * @return \luhaoz\cpl\pubsub\PubSub
     */
    public function pubSubs()
    {
        if ($this->_pubSubs === null) {
            $this->_pubSubs = new \luhaoz\cpl\pubsub\PubSub();
        }
        return $this->_pubSubs;
    }
}