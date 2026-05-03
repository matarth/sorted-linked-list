<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList\Comparator;

/**
 * @implements ComparatorInterface<string>
 */
final class StringComparator implements ComparatorInterface
{
    /**
     * @param string $a
     * @param string $b
     */
    public function compare(mixed $a, mixed $b): int
    {
        return $a <=> $b;
    }
}
