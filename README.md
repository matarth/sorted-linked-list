# sorted-linked-list

A small PHP library for sorted linked lists. It supports ready-made integer and
string lists, and it can be extended with custom comparators and validators for
your own value types.

## Installation

Install the package with Composer:

```bash
composer require mt/sorted-linked-list
```

For local development in this repository, install dependencies with:

```bash
composer install
```

## Basic usage

Create a list for integers with `SortedLinkedList::createIntLinkedList()`:

```php
<?php

declare(strict_types=1);

use Mt\SortedLinkedList\SortedLinkedList;

require __DIR__ . '/vendor/autoload.php';

$list = SortedLinkedList::createIntLinkedList();

$list->add(3);
$list->add(1);
$list->add(2);

foreach ($list as $value) {
    echo $value . PHP_EOL;
}

// Outputs:
// 1
// 2
// 3
```

Lists are sorted in ascending order by default. To sort values in descending
order, pass `SortMethod::DESC`:

```php
use Mt\SortedLinkedList\Enum\SortMethod;

$list = SortedLinkedList::createIntLinkedList(SortMethod::DESC);

$list->add(3);
$list->add(1);
$list->add(2);

iterator_to_array($list->getIterator());
// [3, 2, 1]
```

Create a list for strings with `SortedLinkedList::createStringLinkedList()`:

```php
$list = SortedLinkedList::createStringLinkedList();

$list->add('pear');
$list->add('apple');
$list->add('banana');

iterator_to_array($list->getIterator());
// ['apple', 'banana', 'pear']
```

## Available operations

```php
$list = SortedLinkedList::createIntLinkedList();

$list->add(10);
$list->add(20);

$list->contains(10); // true
$list->contains(30); // false

$list->remove(10);

$list->count(); // 1
```

The list implements `IteratorAggregate` and `Countable`, so it can be used with
`foreach` and `count()`:

```php
count($list);

foreach ($list as $value) {
    // ...
}
```

## Custom value types

To store custom values, implement `ComparatorInterface` and
`ValueValidatorInterface`, then pass them to the `SortedLinkedList` constructor.
The optional `method` constructor parameter accepts `SortMethod::ASC` or
`SortMethod::DESC`; when omitted, it defaults to `SortMethod::ASC`.

This example stores `Person` objects sorted by age:

```php
<?php

declare(strict_types=1);

use Mt\SortedLinkedList\Comparator\ComparatorInterface;
use Mt\SortedLinkedList\Enum\SortMethod;
use Mt\SortedLinkedList\SortedLinkedList;
use Mt\SortedLinkedList\Validator\ValueValidatorInterface;

final readonly class Person
{
    public function __construct(
        public string $name,
        public int $age,
    ) {
    }
}

/**
 * @implements ComparatorInterface<Person>
 */
final class PersonAgeComparator implements ComparatorInterface
{
    public function compare(mixed $a, mixed $b): int
    {
        return $a->age <=> $b->age;
    }
}

/**
 * @implements ValueValidatorInterface<Person>
 */
final class PersonValidator implements ValueValidatorInterface
{
    public function validate(mixed $value): void
    {
        if (!$value instanceof Person) {
            throw new InvalidArgumentException('Expected Person.');
        }
    }
}

/**
 * @var SortedLinkedList<Person> $people
 */
$people = new SortedLinkedList(
    comparator: new PersonAgeComparator(),
    valueValidator: new PersonValidator(),
    method: SortMethod::ASC,
);

$people->add(new Person('Alice', 34));
$people->add(new Person('Bob', 28));
$people->add(new Person('Carol', 41));

foreach ($people as $person) {
    echo $person->name . PHP_EOL;
}

// Outputs:
// Bob
// Alice
// Carol
```

## Development

The project includes Docker Compose commands through `make`:

```bash
make test
make phpstan
make cs
```

`make cs` runs PHP-CS-Fixer and may update files in place.
