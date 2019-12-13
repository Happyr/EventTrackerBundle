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
    public function getTargetIdentifier(): int;

    /**
     * @return string
     */
    public function getName(): string;
}
