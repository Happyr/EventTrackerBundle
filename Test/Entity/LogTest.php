<?php

namespace Happyr\EventTrackerBundle\Test\Entity;

use Happyr\EventTrackerBundle\Entity\Log;

/**
 * @author Tobias Nyholm
 */
class LogTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $log = new Log();
        $this->assertNotNull($log->getTime(), 'A timestamp should be created with the Log');
    }
}
