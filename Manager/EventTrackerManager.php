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
    public function createdBy($target)
    {
        return $this->actionedBy($target, 'created');
    }

    /**
     * @param $target
     *
     * @return Log
     */
    public function updatedBy($target)
    {
        return $this->actionedBy($target, 'updated');
    }

    /**
     * @param $target
     *
     * @return Log
     */
    abstract public function actionedBy($target, $action);
}
