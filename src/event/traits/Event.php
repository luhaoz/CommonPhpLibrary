<?php

namespace luhaoz\cpl\event\traits;

use luhaoz\cpl\event\EventManager;

trait Event
{
    protected $_events = null;

    /**
     * @return EventManager
     */
    public function events()
    {
        if ($this->_events === null) {
            $this->_events = new EventManager();
        }
        return $this->_events;
    }
}