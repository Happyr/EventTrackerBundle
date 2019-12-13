<?php

namespace Happyr\EventTrackerBundle\Manager;

use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class EventTrackerManager implements EventTrackerManagerInterface
{
    /**
     * @param mixed $target
     */
    public function getCreatedLog($target): Log
    {
        return $this->getLog($target, 'created');
    }

    /**
     * @param mixed $target
     */
    public function getCreator($target): ?EventUserInterface
    {
        if (null === $log = $this->getCreatedLog($target)) {
            return null;
        }

        return $log->getUser();
    }

    /**
     * @param mixed $target
     */
    public function getUpdatedLog($target): Log
    {
        return $this->getLog($target, 'updated');
    }

    /**
     * @param $target
     *
     * @return string
     */
    protected function getNamespace($target)
    {
        $fqn = \get_class($target);

        return \mb_strtolower(\mb_substr($fqn, \mb_strrpos($fqn, '\\') + 1));
    }
}
