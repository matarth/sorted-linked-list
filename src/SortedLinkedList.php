<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList;

use Mt\SortedLinkedList\Comparator\ComparatorInterface;
use Mt\SortedLinkedList\Comparator\IntComparator;
use Mt\SortedLinkedList\Comparator\StringComparator;
use Mt\SortedLinkedList\Enum\SortMethod;
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
        private readonly SortMethod $method = SortMethod::ASC,
    ) {
        $this->count = 0;
    }

    /**
     * @param T $value
     */
    public function add(mixed $value): void
    {
        $this->valueValidator->validate($value);

        if (null === $this->root || $this->compare($value, $this->root->getValue()) < 0) {
            $this->root = new Node(
                next: $this->root,
                value: $value,
            );
            ++$this->count;

            return;
        }

        $currentNode = $this->root;
        while (null !== $currentNode->getNext() && $this->compare($value, $currentNode->getNext()->getValue()) > 0) {
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

        if (0 === $this->compare($this->root->getValue(), $value)) {
            $this->root = $this->root->getNext();
            --$this->count; // @phpstan-ignore-line

            return;
        }

        /** @var Node<T> $currentNode */
        $currentNode = $this->root;
        while (null !== $currentNode->getNext()) {
            if (0 === $this->compare($currentNode->getNext()->getValue(), $value)) {
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
            if (0 === $this->compare($nodeValue, $value)) {
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
    public static function createIntLinkedList(SortMethod $method = SortMethod::ASC): self
    {
        return new self(
            comparator: new IntComparator(),
            valueValidator: new IntValueValidator(),
            method: $method,
        );
    }

    /**
     * @return self<string>
     */
    public static function createStringLinkedList(SortMethod $method = SortMethod::ASC): self
    {
        return new self(
            comparator: new StringComparator(),
            valueValidator: new StringValueValidator(),
            method: $method,
        );
    }

    /**
     * @param T $left
     * @param T $right
     */
    private function compare(mixed $left, mixed $right): int
    {
        $result = $this->comparator->compare($left, $right);

        return SortMethod::DESC === $this->method ? -1 * $result : $result;
    }
}
