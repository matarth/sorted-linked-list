<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList\Validator;

use Mt\SortedLinkedList\Exception\UnsupportedTypeException;

/**
 * @implements ValueValidatorInterface<string>
 */
class StringValueValidator implements ValueValidatorInterface
{
    /**
     * @param string $value
     */
    public function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw UnsupportedTypeException::stringRequired();
        }
    }
}
