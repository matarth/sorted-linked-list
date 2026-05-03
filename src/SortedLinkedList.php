<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList;

use Mt\SortedLinkedList\Comparator\ComparatorInterface;
use Mt\SortedLinkedList\Comparator\IntComparator;
use Mt\SortedLinkedList\Comparator\StringComparator;
use Mt\SortedLinkedList\Validator\IntValueValidator;
use Mt\SortedLinkedList\Validator\StringValueValidator;
use Mt\SortedLinkedList\Validator\ValueValidatorInterface;

/**
 * @template T
 *
 * @implements SortedLinkedListInterface<T>
 */
final class SortedLinkedList implements SortedLinkedListInterface
{
    /** @var null|Node<T> */
    private ?Node $root = null;

    /** @var int<0,max> */
    private int $count;

    public function __construct(
        /** @var ComparatorInterface<T> */
        private readonly ComparatorInterface $comparator,
        /** @var ValueValidatorInterface<T> */
        private readonly ValueValidatorInterface $valueValidator,
    ) {
        $this->count = 0;
    }

    /**
     * @param T $value
     */
    public function add(mixed $value): void
    {
        $this->valueValidator->validate($value);

        if (null === $this->root || $this->comparator->compare($value, $this->root->getValue()) < 0) {
            $this->root = new Node(
                next: $this->root,
                value: $value,
            );
            ++$this->count;

            return;
        }

        $currentNode = $this->root;
        while (null !== $currentNode->getNext() && $this->comparator->compare($value, $currentNode->getNext()->getValue()) > 0) {
            $currentNode = $currentNode->getNext();
        }

        $currentNode->setNext(new Node(
            next: $currentNode->getNext(),
            value: $value,
        ));
        ++$this->count;
    }

    /**
     * @param T $value
     */
    public function remove(mixed $value): void
    {
        if (null === $this->root) {
            return;
        }

        if (0 === $this->comparator->compare($this->root->getValue(), $value)) {
            $this->root = $this->root->getNext();
            --$this->count; // @phpstan-ignore-line

            return;
        }

        /** @var Node<T> $currentNode */
        $currentNode = $this->root;
        while (null !== $currentNode->getNext()) {
            if (0 === $this->comparator->compare($currentNode->getNext()->getValue(), $value)) {
                $currentNode->setNext($currentNode->getNext()->getNext());
                --$this->count; // @phpstan-ignore-line

                return;
            }
            $currentNode = $currentNode->getNext();
        }
    }

    /**
     * @param T $value
     */
    public function contains(mixed $value): bool
    {
        foreach ($this as $nodeValue) {
            if (0 === $this->comparator->compare($nodeValue, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Traversable<int, T>
     */
    public function getIterator(): \Traversable
    {
        $currentNode = $this->root;

        while (null !== $currentNode) {
            yield $currentNode->getValue();

            $currentNode = $currentNode->getNext();
        }
    }

    /**
     * @return int<0,max>
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @return self<int>
     */
    public static function createIntLinkedList(): self
    {
        return new self(
            comparator: new IntComparator(),
            valueValidator: new IntValueValidator(),
        );
    }

    /**
     * @return self<string>
     */
    public static function createStringLinkedList(): self
    {
        return new self(
            comparator: new StringComparator(),
            valueValidator: new StringValueValidator(),
        );
    }
}
