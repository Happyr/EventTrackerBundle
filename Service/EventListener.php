<?php

namespace Happyr\EventTrackerBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Happyr\EventTrackerBundle\Entity\EventUserInterface;
use Happyr\EventTrackerBundle\Entity\Log;
use Happyr\EventTrackerBundle\Event\TrackableEventInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Tobias Nyholm
 */
class EventListener
{
    /**
     * @var array actionMap array('eventName'=>array('action'=>'foo', 'namespace'=>'bar')
     */
    protected $actionMap;

    /**
     * @var EntityManagerInterface em
     */
    protected $em;

    /**
     * @var TokenStorageInterface tokenStorage
     */
    protected $tokenStorage;
    
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, array $actionMap = array())
    {
        $this->actionMap = $actionMap;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param TrackableEventInterface $event
     */
    public function createLog(TrackableEventInterface $event)
    {
        $log = new Log();
        $log->setTarget($event->getTargetIdentifier())
            ->setNamespace($this->getNamespace($event))
            ->setAction($this->getAction($event))
            ->setUser($this->getUser($event));

        $this->em->persist($log);
        $this->em->flush($log);
    }

    /**
     * Get the user from the event or the token.
     *
     * @return EventUserInterface|void
     */
    protected function getUser(TrackableEventInterface $event)
    {
        /*
         * Try to get the user from the event
         */
        if (method_exists($event, 'getUser')) {
            return $event->getUser();
        }

        /*
         * Try to get the user id from the event
         */
        if (method_exists($event, 'getUserId')) {
            return $this->em->getRepository('HappyrEventTrackerBundle:EventUserInterface')->findOneById($event->getUserId());
        }

        /*
         * Try to get user form token
         */
        if (null === $token = $this->tokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    /**
     * @param TrackableEventInterface $event
     *
     * @return string
     */
    protected function getAction(TrackableEventInterface $event)
    {
        return $this->actionMap[$event->getName()]['action'];
    }

    /**
     * @param TrackableEventInterface $event
     *
     * @return string
     */
    protected function getNamespace(TrackableEventInterface $event)
    {
        return $this->actionMap[$event->getName()]['namespace'];
    }
}
