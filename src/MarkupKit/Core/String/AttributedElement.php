<?php

namespace MarkupKit\Core\String;

interface AttributedElement
{
    // phpcs:ignore
    public AttributeContainer $attributes {
        get;
    }

    public function withAttribute(Attribute $attribute): static;
    public function withoutAttributes(): static;
    public function replacingAttributes(AttributeContainer $attributes): static;
}
