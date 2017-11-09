<?php

namespace Happyr\EventTrackerBundle\Event;

/**
 * @author Tobias Nyholm
 */
interface TrackableEventInterface
{
    /**
     * @return int
     */
    public function getTargetIdentifier();

    /**
     * @return string
     */
    public function getName();
}
