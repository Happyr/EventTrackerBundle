<?php

declare(strict_types=1);

namespace Happyr\EventTrackerBundle\Manager;

use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
interface EventTrackerManagerInterface
{
    /**
     * @param mixed $target
     */
    public function getLog($target, string $action): ?Log;
}
