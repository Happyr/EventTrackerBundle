<?php

namespace Happyr\EventTrackerBundle\Service;

use Doctrine\ORM\EntityManager;
use Happyr\EventTrackerBundle\Entity\Log;
use Happyr\EventTrackerBundle\Event\TrackableEventInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\SecurityContextInterface;

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
     * @param TrackableEventInterface $event
     */
    public function createLog(TrackableEventInterface $event)
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
     * @return string user
     */
    protected function getUser()
    {
        if (null === $token = $this->securityContext->getToken()) {
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
