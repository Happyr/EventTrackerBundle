<?php

namespace Happyr\EventTrackerBundle\Event;

/**
 * @author Tobias Nyholm
 */
interface TrackableEvent
{
    public function getTargetIdentifier();
}
