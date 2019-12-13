<?php

namespace Happyr\EventTrackerBundle\Twig;

use Happyr\EventTrackerBundle\Manager\EventTrackerManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @author Tobias Nyholm
 */
class EventTrackerExtension extends AbstractExtension
{
    /**
     * @var EventTrackerManager etm
     */
    private $etm;

    /**
     * @param EventTrackerManager $etm
     */
    public function __construct(EventTrackerManager $etm)
    {
        $this->etm = $etm;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new TwigFilter('createdBy', array($this->etm, 'getCreatedLog')),
            new TwigFilter('updatedBy', array($this->etm, 'getUpdatedLog')),
            new TwigFilter('actionedBy', array($this->etm, 'getLog')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'happyr_event_tracker_extension';
    }
}
