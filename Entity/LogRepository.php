<?php

namespace Happyr\EventTrackerBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @author Tobias Nyholm
 */
class LogRepository extends EntityRepository
{
    /**
     * @param string $namespace
     * @param string $user
     * @param string $action
     *
     * @return \Happyr\EventTrackerBundle\Entity\Log[]
     */
    public function getEventsByTarget($namespace, $target, $action = null)
    {
        $criteria = array('namespace'=>$namespace, 'target' => $target);

        if ($action !== null) {
            $criteria['action'] = $action;
        }

        return $this->findBy($criteria);
    }

    /**
     * @param string $user
     * @param string $namespace
     * @param string $action
     *
     * This does not load the user for each event
     *
     * @return \Happyr\EventTrackerBundle\Entity\Log[]
     */
    public function getEventsByUser($user, $namespace = null, $action = null)
    {
        $criteria = array('user' => $user);

        if ($action !== null) {
            $criteria['action'] = $action;
        }

        if ($namespace !== null) {
            $criteria['namespace'] = $namespace;
        }

        return $this->findBy($criteria);
    }
} 