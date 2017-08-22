<?php

namespace luhaoz\cpl\event;

use luhaoz\cpl\pool\HashPool;

/**
 * Class EventManager
 * @package luhaoz\cpl\event
 */
class EventManager
{
    protected $_eventPool = null;

    public function eventPool()
    {
        if ($this->_eventPool === null) {
            $this->_eventPool = new HashPool();
        }
        return $this->_eventPool;
    }

    public function on($eventName, $event)
    {
        $this->eventPool()->set($eventName, $event);
        return $this;
    }

    public function has($eventName)
    {
        return $this->eventPool()->has($eventName);
    }

    public function event($eventName)
    {
        return $this->eventPool()->get($eventName);
    }

    public function exec($eventName, $parameter = [])
    {
        $eventRun = $this->event($eventName);
        if (is_array($eventRun) && class_exists($eventRun[0])) {
            $eventClass = $eventRun[0];
            $runClass = new $eventClass();
            $runMethod = $eventRun[1];
            $eventRun = [$runClass, $runMethod];
        }
        return call_user_func_array($eventRun, $parameter);
    }

    public function trigger($eventName, $parameter = [])
    {
        if ($this->has($eventName)) {
            return $this->exec($eventName, $parameter);
        }
        return null;
    }
}