<?php

namespace Happyr\EventTrackerBundle\Manager;

use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm
 * This manager fetches all the events related to the target and store them im a memory cache.
 */
class AggressiveManager extends DatabaseManager
{
    /**
     * @var array storage A storage with previous data that we fetched
     */
    private $storage;

    /**
     * @param $target
     * @param $action
     *
     * @return Log|void
     */
    public function actionedBy($target, $action)
    {
        $class = $this->getNamespace($target);
        $key = $this->getKey($target, $class);

        if (!isset($this->storage[$key])) {
            $this->fetchFromDb($target, $class);
        }

        if (!isset($this->storage[$key][$action])) {
            return;
        }

        $log = $this->storage[$key][$action];

        if (is_string($log->getUser())) {
            $this->setUser($log);
        }

        return $log;
    }

    /**
     * fetch all actions on this target.
     *
     * @param $target
     * @param $class
     *
     * @return Log
     */
    private function fetchFromDb($target, $class)
    {
        $key = $this->getKey($target, $class);

        $logs = $this->em->getRepository('HappyrEventTrackerBundle:Log')
            ->findBy(
                array(
                    'namespace' => $class,
                    'target' => $target->getId(),
                ),
                array('time' => 'DESC')
            );

        foreach ($logs as $log) {
            if (!isset($this->storage[$key][$log->getAction()])) {
                $this->storage[$key][$log->getAction()] = $log;
            }
        }
    }

    /**
     * @param $target
     * @param $class
     *
     * @return string
     */
    private function getKey($target, $class)
    {
        return $class.$target->getId();
    }
}
