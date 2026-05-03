<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList\Validator;

/** @template T */
interface ValueValidatorInterface
{
    /**
     * @param T $value
     */
    public function validate(mixed $value): void;
}
