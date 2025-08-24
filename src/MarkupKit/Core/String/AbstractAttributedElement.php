<?php

namespace MarkupKit\Core\String;

use UnitEnum;

abstract readonly class AbstractAttributedElement implements AttributedElement
{
    public AttributeContainer $attributes;

    /**
     * @param AttributeContainer|array<int, Attribute> $attributes
     */
    public function __construct(
        AttributeContainer|array $attributes = []
    ) {
        $this->attributes = $attributes instanceof AttributeContainer ? $attributes : new AttributeContainer($attributes);
    }

    public function withAttribute(Attribute $attribute): static
    {
        return $this->replacingAttributes(
            $this->attributes->withAttribute($attribute)
        );
    }

    /**
     * @param class-string<Attribute>|(Attribute&UnitEnum) $attribute
     */
    public function withoutAttribute(string|Attribute $attribute): static
    {
        return $this->replacingAttributes(
            $this->attributes->withoutAttribute($attribute)
        );
    }

    public function withoutAttributes(): static
    {
        return $this->replacingAttributes(new AttributeContainer());
    }

    abstract public function replacingAttributes(AttributeContainer $attributes): static;
}
