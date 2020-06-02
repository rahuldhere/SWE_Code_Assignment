<?php
use PHPUnit\Framework\TestCase;

require_once('assignment.php');

final class RobotTest extends TestCase
{
    public function testchargeBattery(): void
    {
        $robot = new Robot();
        $this->assertEquals(100, $robot->chargeBattery());
    }
}

