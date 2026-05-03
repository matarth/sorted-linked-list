<?php
declare(strict_types=1);

use Mt\SortedLinkedList\Comparator\IntComparator;
use PHPUnit\Framework\TestCase;

class IntComparatorTest extends TestCase
{

    public function testItComparesIntegers(): void
    {
        $this->assertEquals(-1, (new IntComparator())->compare(1, 2));
        $this->assertEquals(1, (new IntComparator())->compare(2, 1));
        $this->assertEquals(0, (new IntComparator())->compare(2, 2));
        $this->assertEquals(-1, (new IntComparator())->compare(-1, 0));
        $this->assertEquals(1, (new IntComparator())->compare(0, -1));
    }

}