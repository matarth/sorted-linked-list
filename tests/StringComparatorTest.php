<?php
declare(strict_types=1);

use Mt\SortedLinkedList\Comparator\StringComparator;
use PHPUnit\Framework\TestCase;

class StringComparatorTest extends TestCase
{

    public function testItComparesStrings(): void
    {
        $this->assertEquals(-1, (new StringComparator())->compare('a', 'b'));
        $this->assertEquals(1, (new StringComparator())->compare('b', 'a'));
        $this->assertEquals(0, (new StringComparator())->compare('b', 'b'));
        $this->assertEquals(-1, (new StringComparator())->compare('b', 'bbb'));
        $this->assertEquals(-1, (new StringComparator())->compare('aab', 'abc'));
        $this->assertEquals(-1, (new StringComparator())->compare('A', 'a'));
    }

}