<?php

namespace Happyr\EventTrackerBundle\Event;

/**
 * @author Tobias Nyholm
 */
interface TrackableEventInterface
{
    public function getTargetIdentifier();
}
