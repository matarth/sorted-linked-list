<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Dummy.php';

final class DummyTest extends TestCase
{

    public function testGetReturnsTrue(): void
    {
        $dummy = new Dummy();

        self::assertTrue($dummy->get());
    }
}
