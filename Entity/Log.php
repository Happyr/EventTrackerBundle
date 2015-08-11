<?php

namespace Happyr\EventTrackerBundle\Entity;

class Log
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \Datetime
     */
    protected $time;

    /**
     * @var mixed targetId
     */
    protected $target;

    /**
     * @var string targetId
     */
    protected $action;

    /**
     * @var string namespace
     */
    protected $namespace;

    /**
     * @var EventUserInterface
     */
    protected $user;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->time = new \DateTime();
    }

    public function __toString()
    {
        if ($this->user === null) {
            return '';
        }

        return (string) $this->user;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $target
     *
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param \Datetime $time
     *
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param EventUserInterface $user
     *
     * @return $this
     */
    public function setUser(EventUserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return EventUserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $namespace
     *
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
