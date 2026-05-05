<?php

declare(strict_types=1);

use Mt\SortedLinkedList\Comparator\ComparatorInterface;
use Mt\SortedLinkedList\Exception\UnsupportedTypeException;
use Mt\SortedLinkedList\SortedLinkedList;
use Mt\SortedLinkedList\Validator\ValueValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class CustomClassSortedLinkedListTest extends TestCase
{
    public function testItSortsCustomClassInstances(): void
    {
        $oldest = new CustomSortedLinkedListPerson('Alice', 42);
        $youngest = new CustomSortedLinkedListPerson('Bob', 21);
        $middle = new CustomSortedLinkedListPerson('Carol', 35);

        $list = new SortedLinkedList(
            comparator: new CustomSortedLinkedListPersonComparator(),
            valueValidator: new CustomSortedLinkedListPersonValidator(),
        );

        $list->add($oldest);
        $list->add($youngest);
        $list->add($middle);

        self::assertSame([$youngest, $middle, $oldest], iterator_to_array($list->getIterator()));
        self::assertSame(3, $list->count());
        self::assertTrue($list->contains(new CustomSortedLinkedListPerson('Another 35 year old', 35)));
    }

    public function testItThrowsExceptionWhenRemovingValueOfDifferentType(): void
    {
        $list = new SortedLinkedList(
            comparator: new CustomSortedLinkedListPersonComparator(),
            valueValidator: new CustomSortedLinkedListPersonValidator(),
        );

        $list->add(new CustomSortedLinkedListPerson('Alice', 42));

        $this->expectException(UnsupportedTypeException::class);
        $list->remove('Bob'); // @phpstan-ignore-line
        self::assertCount(1, $list);
    }
}

final readonly class CustomSortedLinkedListPerson
{
    public function __construct(
        public string $name,
        public int $age,
    ) {}
}

/**
 * @implements ComparatorInterface<CustomSortedLinkedListPerson>
 */
final class CustomSortedLinkedListPersonComparator implements ComparatorInterface
{
    public function compare(mixed $a, mixed $b): int
    {
        return $a->age <=> $b->age;
    }
}

/**
 * @implements ValueValidatorInterface<CustomSortedLinkedListPerson>
 */
final class CustomSortedLinkedListPersonValidator implements ValueValidatorInterface
{
    public function validate(mixed $value): void
    {
        if (!$value instanceof CustomSortedLinkedListPerson) {
            throw new UnsupportedTypeException('Expected CustomSortedLinkedListPerson');
        }
    }
}
