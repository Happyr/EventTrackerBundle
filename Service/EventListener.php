<?php

namespace Happyr\EventTrackerBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Happyr\EventTrackerBundle\Entity\Log;
use Happyr\EventTrackerBundle\Event\TrackableEventInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

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
     * @var \Doctrine\ORM\EntityManager em
     */
    protected $em;

    /**
     * @var TokenStorage tokenStorage
     */
    protected $tokenStorage;

    /**
     * @param EntityManagerInterface $em
     * @param TokenStorage           $tokenStorage
     * @param array                  $actionMap
     */
    public function __construct(EntityManagerInterface $em, TokenStorage $tokenStorage, array $actionMap = array())
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
            ->setUser($this->getUser());

        $this->em->persist($log);
        $this->em->flush($log);
    }

    /**
     * Get the user.
     *
     * @return string user
     */
    protected function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user->getUsername();
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
