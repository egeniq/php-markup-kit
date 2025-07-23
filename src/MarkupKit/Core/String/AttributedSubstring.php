<?php

namespace MarkupKit\Core\String;

use Stringable;

readonly class AttributedSubstring implements AttributedElement, Stringable
{
    public function __construct(
        public string $string,
        public AttributeContainer $attributes
    ) {
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
