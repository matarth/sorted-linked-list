<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList;

/**
 * @template T
 */
final class Node
{
    /** @var null|self<T> */
    private ?self $next;

    /** @var T */
    private mixed $value;

    /**
     * @param T            $value
     * @param null|self<T> $next
     */
    public function __construct(
        ?self $next,
        mixed $value,
    ) {
        $this->next = $next;
        $this->value = $value;
    }

    /**
     * @return null|self<T>
     */
    public function getNext(): ?self
    {
        return $this->next;
    }

    /**
     * @param null|self<T> $next
     */
    public function setNext(?self $next): void
    {
        $this->next = $next;
    }

    /**
     * @return T
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
