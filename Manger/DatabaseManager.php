<?php

namespace Happyr\EventTrackerBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm
 */
class DatabaseManager extends EventTrackerManager
{
    /**
     * @var EntityManagerInterface em
     */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $target
     *
     * @return Log
     */
    public function actionedBy($target, $action)
    {
        $class = $this->getNamespace($target);

        if (null === $log = $this->em->getRepository('HappyrEventTrackerBundle:Log')
                ->findOneBy(
                    array(
                        'namespace' => $class,
                        'target' => $target->getId(),
                        'action' => $action,
                    ),
                    array('time' => 'DESC')
                )
        ) {
            return;
        }

        $this->setUser($log);

        return $log;
    }

    /**
     * @param $target
     *
     * @return string
     */
    protected function getNamespace($target)
    {
        $fqn = get_class($target);
        $class = strtolower(substr($fqn, strrpos($fqn, '\\') + 1));

        return $class;
    }

    /**
     * @param $log
     *
     * @return mixed
     */
    protected function setUser(Log $log)
    {
        $user = $this->em->getRepository('CarlinUserUserBundle:User')->findOneByEmail($log->getUser());
        $log->setUser($user);
    }
}
