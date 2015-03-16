<?php

namespace Happyr\EventTrackerBundle\Service;

use Doctrine\ORM\EntityManager;
use Happyr\EventTrackerBundle\Entity\Log;
use Happyr\EventTrackerBundle\Event\TrackableEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Tobias Nyholm
 */
class EventListener
{
    /**
     * @var array actionMap array('eventName'=>'action')
     */
    protected $actionMap;

    /**
     * @var \Doctrine\ORM\EntityManager em
     */
    protected $em;

    /**
     * @var SecurityContextInterface securityContext
     */
    protected $securityContext;

    /**
     * @param EntityManager            $em
     * @param SecurityContextInterface $securityContext
     * @param array                    $actionMap
     */
    public function __construct(EntityManager $em, SecurityContextInterface $securityContext, array $actionMap = array())
    {
        $this->actionMap = $actionMap;
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    /**
     * @param TrackableEvent $event
     */
    public function createLog(TrackableEvent $event)
    {
        $log = new Log();
        $log->setTarget($event->getTargetIdentifier())
            ->setAction($this->getAction($event))
            ->setUser($this->getUser());

        $this->em->persist($log);
        $this->em->flush($log);
    }

    /**
     * Get the user.
     *
     * @return mixed user
     */
    protected function getUser()
    {
        if (null === $token = $this->securityContext->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    /**
     * @param TrackableEvent $event
     *
     * @return mixed
     */
    protected function getAction(Event $event)
    {
        return $this->actionMap[$event->getName()];
    }
}
