<?php

namespace MarkupKit\Core;

use ArrayAccess;
use DOMElement;
use DOMText;
use InvalidArgumentException;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;

/**
 * @implements ArrayAccess<string, mixed>
 *
 * @template T
 */
class Context implements ArrayAccess
{
    /**
     * @var array<string, mixed>
     */
    private array $values = [];

    /**
     * @param Options<T> $options
     */
    public function __construct(
        public readonly Options $options
    ) {
    }

    /**
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node): array
    {
        return $this->options->nodeParsers->parseFlowNode($node, $this);
    }

    public function parsePhrasingNode(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes
    ): void {
        $this->options->nodeParsers->parsePhrasingNode($node, $stringBuilder, $attributes, $this);
    }

    public function hasValue(string $key): bool
    {
        return isset($this->values[$key]);
    }

    public function getValue(string $key): mixed
    {
        return $this->values[$key] ?? null;
    }

    public function setValue(string $key, mixed $value): void
    {
        $this->values[$key] = $value;
    }

    public function unsetValue(string $key): void
    {
        unset($this->values[$key]);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->hasValue($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getValue($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_string($offset)) {
            throw new InvalidArgumentException('Offset must be a string.');
        }

        $this->setValue($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->unsetValue($offset);
    }
}
