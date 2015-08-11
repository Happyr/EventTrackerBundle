<?php

namespace Happyr\EventTrackerBundle\Twig;

use Happyr\EventTrackerBundle\Manager\EventTrackerManager;

/**
 * @author Tobias Nyholm
 */
class EventTrackerExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('createdBy', array($this->etm, 'createdBy')),
            new \Twig_SimpleFilter('updatedBy', array($this->etm, 'updatedBy')),
            new \Twig_SimpleFilter('actionedBy', array($this->etm, 'actionedBy')),
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
