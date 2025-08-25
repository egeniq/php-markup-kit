<?php

namespace MarkupKit\Core\String;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use UnitEnum;

/**
 * @implements IteratorAggregate<int, Attribute>
 */
readonly class AttributeContainer implements IteratorAggregate, Countable
{
    /**
     * @param Attribute[] $attributes
     */
    public function __construct(
        public array $attributes = [],
    ) {
    }

    public function withAttribute(Attribute $attribute): self
    {
        $attributes = [];

        if ($attribute instanceof UniqueAttribute) {
            foreach ($this->attributes as $attr) {
                if (is_a($attr, get_class($attribute))) {
                    continue;
                }

                $attributes[] = $attr;
            }
        } else {
            $attributes = $this->attributes;
        }

        $attributes[] = $attribute;
        return new self($attributes);
    }


    /**
     * @param class-string<Attribute>|(Attribute&UnitEnum) $attribute
     */
    public function withoutAttribute(string|Attribute $attribute): self
    {
        return $this->filterAttributes(
            fn (Attribute $attr) => $attribute instanceof Attribute ? $attr !== $attribute : !is_a($attr, $attribute)
        );
    }

    /**
     * Check if the container contains a specific attribute, or one or more attributes of a specific type.
     *
     * @param class-string<Attribute>|(Attribute&UnitEnum) $attribute
     *
     * @return bool
     */
    public function hasAttribute(string|(Attribute&UnitEnum) $attribute): bool
    {
        if ($attribute instanceof Attribute) {
            return in_array($attribute, $this->attributes, true);
        }

        foreach ($this->attributes as $attr) {
            if ($attr instanceof $attribute) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param class-string<TUniqueAttr>|TEnum $attribute
     *
     * @return ($attribute is class-string ? TUniqueAttr : TEnum)
     *
     * @template TUniqueAttr of UniqueAttribute
     * @template TEnum of (Attribute&UnitEnum)
     */
    public function getAttribute(string|(Attribute&UnitEnum) $attribute): ?Attribute
    {
        if ($attribute instanceof Attribute && in_array($attribute, $this->attributes, true)) {
            return $attribute;
        }

        if ($attribute instanceof Attribute) {
            return null;
        }

        foreach ($this->attributes as $attr) {
            if ($attr instanceof $attribute) {
                return $attr;
            }
        }

        return null;
    }

    /**
     * @param class-string<Attribute>|(callable(Attribute $attribute): bool) $filter
     *
     * @return self
     */
    public function filterAttributes(string|callable $filter): self
    {
        if (is_string($filter)) {
            $filter = fn (Attribute $attr) => $attr instanceof $filter;
        }

        return new self(array_filter($this->attributes, $filter));
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }

    public function count(): int
    {
        return count($this->attributes);
    }

    public function isEmpty(): bool
    {
        return empty($this->attributes);
    }

    public function diff(self $other): AttributeContainer
    {
        return $this->filterAttributes(fn (Attribute $attr) => !in_array($attr, $other->attributes, true));
    }

    public function reversed(): AttributeContainer
    {
        return new self(array_reverse($this->attributes));
    }

    public function equals(AttributeContainer $other): bool
    {
        if ($this === $other) {
            return true;
        }

        if (count($this->attributes) !== count($other->attributes)) {
            return false;
        }

        return $this->diff($other)->isEmpty() && $other->diff($this)->isEmpty();
    }
}
