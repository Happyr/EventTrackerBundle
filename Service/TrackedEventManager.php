<?php

namespace Happyr\EventTrackerBundle\Service;

use Doctrine\ORM\EntityManager;
use Happyr\EventTrackerBundle\Entity\Log;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Tobias Nyholm
 */
class TrackedEventManager
{
    /**
     * @var \Symfony\Component\Security\Core\User\UserProviderInterface userProvider
     */
    protected $userProvider;

    /**
     * @var \Doctrine\ORM\EntityManager em
     */
    protected $em;

    /**
     * @param EntityManager         $em
     * @param UserProviderInterface $userProvider
     */
    public function __construct(EntityManager $em, UserProviderInterface $userProvider)
    {
        $this->em = $em;
        $this->userProvider = $userProvider;
    }

    /**
     * Fetch tracked events.
     *
     * @param array $criteria ('target', 'user', 'action', 'namespace')
     * @param array $order
     */
    public function getEvents(array $criteria, array $order = array(), $loadUsers = true)
    {
        /** @var Log[] $logs */
        $logs = $this->em->getRepository('HappyrEventTrackerBundle:Log')
            ->findBy($criteria, $order);

        if ($loadUsers) {
            foreach ($logs as $log) {
                if (null !== $username = $log->getUser()) {
                    $log->setUser($this->userProvider->loadUserByUsername($username));
                }
            }
        }

        return $logs;
    }

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

        return $this->getEvents($criteria);
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

        return $this->getEvents($criteria, array(), false);
    }
}
