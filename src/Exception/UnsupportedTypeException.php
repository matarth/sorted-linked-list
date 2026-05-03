<?php

declare(strict_types=1);

namespace Mt\SortedLinkedList\Exception;

class UnsupportedTypeException extends \RuntimeException
{
    public static function intRequired(): self
    {
        return new self('Provided an unsupported type of value. Expected int');
    }

    public static function stringRequired(): self
    {
        return new self('Provided an unsupported type of value. Expected string');
    }
}
