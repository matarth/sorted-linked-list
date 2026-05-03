<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList;

/**
 * @template T
 */
interface SortedLinkedListInterface extends \Countable
{
    /**
     * @param T $value
     */
    public function add(mixed $value): void;

    /**
     * @param T $value
     */
    public function remove(mixed $value): void;

    /**
     * @param T $value
     */
    public function contains(mixed $value): bool;

    /**
     * @return int<0,max>
     */
    public function count(): int;
}
