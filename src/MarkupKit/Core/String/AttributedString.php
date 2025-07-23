<?php

namespace MarkupKit\Core\String;

use MarkupKit\Core\String\Encoder\String\StringEncoder;
use Stringable;

readonly class AttributedString implements Stringable
{
    /**
     * @param AttributedElement[] $elements
     */
    public function __construct(
        public array $elements = []
    ) {
    }

    public function isEmpty(): bool
    {
        return count($this->elements) === 0;
    }

    public function __toString(): string
    {
        return new StringEncoder()->encode($this);
    }
}
