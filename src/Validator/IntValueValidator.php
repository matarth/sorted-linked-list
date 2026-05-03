<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList\Validator;

use Mt\SortedLinkedList\Exception\UnsupportedTypeException;

/**
 * @implements ValueValidatorInterface<int>
 */
class IntValueValidator implements ValueValidatorInterface
{
    /**
     * @param int $value
     */
    public function validate(mixed $value): void
    {
        if (!is_int($value)) {
            throw UnsupportedTypeException::intRequired();
        }
    }
}
