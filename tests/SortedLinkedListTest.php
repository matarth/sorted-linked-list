<?php
declare(strict_types=1);

use Mt\SortedLinkedList\Exception\UnsupportedTypeException;
use Mt\SortedLinkedList\SortedLinkedList;
use PHPUnit\Framework\TestCase;

class SortedLinkedListTest extends TestCase
{

    public function testItAddsValueToEmptyList(): void
    {
        $list = SortedLinkedList::createIntLinkedList();
        $list->add(1);
        self::assertEquals([1], iterator_to_array($list->getIterator()));
    }

    public function testItAddsValueToEndOfList(): void
    {
        $list = SortedLinkedList::createIntLinkedList();
        $list->add(1);
        $list->add(2);
        self::assertEquals([1,2], iterator_to_array($list->getIterator()));
    }

    public function testItAddsValueToCorrectPosition(): void
    {
        $list = SortedLinkedList::createIntLinkedList();
        $list->add(1);
        $list->add(4);
        $list->add(2);
        self::assertEquals([1,2,4], iterator_to_array($list->getIterator()));
    }

    public function testIdAddsValueToBeginningOfList(): void
    {
        $list = SortedLinkedList::createIntLinkedList();
        $list->add(1);
        $list->add(2);
        $list->add(0);
        self::assertEquals([0,1,2], iterator_to_array($list->getIterator()));
    }

    public function testItAddsStringValueToCorrectPosition(): void
    {
        $list = SortedLinkedList::createStringLinkedList();
        $list->add('abc');
        $list->add('abd');
        $list->add('abb');
        $list->add('b');
        self::assertEquals(['abb','abc','abd', 'b'], iterator_to_array($list->getIterator()));
    }

    public function testItThrowsExceptionIfValueIsNotValid(): void
    {
        $list = SortedLinkedList::createIntLinkedList();
        $this->expectException(UnsupportedTypeException::class);
        $list->add('string'); /* @phpstan-ignore-line */
    }

    public function testItThrowsExceptionIfValueIsNotValid2(): void
    {
        $list = SortedLinkedList::createStringLinkedList();
        $this->expectException(UnsupportedTypeException::class);
        $list->add(1); /* @phpstan-ignore-line */
    }

    public function testItThrowsExceptionIfValueIsNotValid3(): void
    {
        $list = SortedLinkedList::createStringLinkedList();
        $this->expectException(UnsupportedTypeException::class);
        $list->add((object) ['x']); /* @phpstan-ignore-line */
    }

    public function testItThrowsExceptionIfValueIsNotValid4(): void
    {
        $list = SortedLinkedList::createStringLinkedList();
        $this->expectException(UnsupportedTypeException::class);
        $list->add(null); /* @phpstan-ignore-line */
    }

}
