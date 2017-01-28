<?php

namespace Ath\MainBundle\Doctrine\DBAL;

use Doctrine\DBAL\Connection as BaseConnection;
use Doctrine\Common\EventManager;

/**
 * Extends Doctrine DBAL connection
 * to add the ability to change the event manager.
 * Used for tests only.
 */
class Connection extends BaseConnection
{
    /**
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->_eventManager = $eventManager;
        $this->_platform->setEventManager($eventManager);
    }
}