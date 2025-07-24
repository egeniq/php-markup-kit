<?php

namespace MarkupKit\Core\String;

use Stringable;

final readonly class AttributedSubstring extends AbstractAttributedElement implements Stringable
{
    public function __construct(
        public string $string,
        AttributeContainer $attributes
    ) {
        parent::__construct($attributes);
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function replacingAttributes(AttributeContainer $attributes): static
    {
        return new self($this->string, $attributes);
    }
}
