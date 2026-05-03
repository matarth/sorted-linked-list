<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList\Comparator;

/**
 * @implements ComparatorInterface<int>
 */
final class IntComparator implements ComparatorInterface
{
    /**
     * @param int $a
     * @param int $b
     */
    public function compare(mixed $a, mixed $b): int
    {
        return $a <=> $b;
    }
}
