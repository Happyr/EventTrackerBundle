<?php

namespace Happyr\EventTrackerBundle\Manager;

use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm
 */
abstract class EventTrackerManager
{
    /**
     * @param $target
     *
     * @return Log
     */
    abstract public function getLog($target, $action);

    /**
     * @param $target
     *
     * @return Log
     */
    public function getCreatedLog($target)
    {
        return $this->getLog($target, 'created');
    }

    /**
     * @param $target
     *
     * @return \Happyr\EventTrackerBundle\Entity\EventUserInterface|void
     */
    public function getCreator($target)
    {
        if (null === $log = $this->getCreatedLog($target)) {
            return;
        }

        return $log->getUser();
    }

    /**
     * @param $target
     *
     * @return Log
     */
    public function getUpdatedLog($target)
    {
        return $this->getLog($target, 'updated');
    }
}
