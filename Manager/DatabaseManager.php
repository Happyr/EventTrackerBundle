<?php

namespace Happyr\EventTrackerBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class DatabaseManager extends EventTrackerManager
{
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

        if (null === $log = $this->em->getRepository(Log::class)
            ->findOneBy(
                    [
                        'namespace' => $class,
                        'target' => $target->getId(),
                        'action' => $action,
                    ],
                    ['time' => 'DESC']
                )
        ) {
            return null;
        }

        return $log;
    }
}
