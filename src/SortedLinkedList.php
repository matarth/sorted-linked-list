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
    private int $count = 0;

    private function __construct(
        /** @var ComparatorInterface<T> */
        private readonly ComparatorInterface $comparator,
        /** @var ValueValidatorInterface<T> */
        private readonly ValueValidatorInterface $valueValidator,
    ) {}

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
        // TODO implement
    }

    /**
     * @param T $value
     */
    public function contains(mixed $value): bool
    {
        foreach ($this as $nodeValue) {
            if ($nodeValue === $value) {
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
