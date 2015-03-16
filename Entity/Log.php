<?php

namespace Happyr\EventTrackerBundle\Entity;

class Log
{
    /**
     * @var integer
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
     * @var string targetId
     */
    protected $user;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->time = new \DateTime();
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
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
