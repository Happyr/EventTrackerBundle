<?php

namespace Happyr\EventTrackerBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Happyr\EventTrackerBundle\Entity\Log;

/**
 * This manager fetches all the events related to the target and store them im a memory cache.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class AggressiveDatabaseManager extends EventTrackerManager
{
    /**
     * @var array storage A storage with previous data that we fetched
     */
    private $storage;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getLog($target, string $action): ?Log
    {
        $class = $this->getNamespace($target);
        $key = $this->getKey($target, $class);

        if (!isset($this->storage[$key])) {
            $this->fetchFromDb($target, $class);
        }

        return $this->storage[$key][$action] ?? null;
    }

    /**
     * fetch all actions on this target.
     *
     * @param mixed $target
     */
    private function fetchFromDb($target, string $class)
    {
        $key = $this->getKey($target, $class);

        $logs = $this->em->getRepository(Log::class)
            ->findBy(
                [
                    'namespace' => $class,
                    'target' => $target->getId(),
                ],
                ['time' => 'DESC']
            );

        foreach ($logs as $log) {
            if (!isset($this->storage[$key][$log->getAction()])) {
                $this->storage[$key][$log->getAction()] = $log;
            }
        }
    }

    /**
     * @param $class
     */
    private function getKey($target, string $class): string
    {
        return $class.$target->getId();
    }
}
