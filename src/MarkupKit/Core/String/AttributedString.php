<?php

namespace MarkupKit\Core\String;

use MarkupKit\Core\String\Encoder\String\StringEncoder;
use MarkupKit\Core\String\Internal\Traits\OptimizeElements;
use Stringable;
use UnitEnum;

readonly class AttributedString implements Stringable
{
    use OptimizeElements;

    /**
     * @var array<AttributedSubstring|Attachment>
     */
    public array $elements;

    /**
     * @param array<AttributedSubstring|Attachment> $elements
     */
    public function __construct(
        array $elements = []
    ) {
        $this->elements = $this->optimizeElements($elements);
    }

    public static function fromString(
        string $string,
        AttributeContainer $attributes = new AttributeContainer()
    ): AttributedString {
        return new AttributedString([new AttributedSubstring($string, $attributes)]);
    }

    public function isEmpty(): bool
    {
        return count($this->elements) === 0;
    }

    /**
     * @return array<AttributedString|Attachment>
     */
    public function splitStringsAndAttachments(): array
    {
        if ($this->isEmpty()) {
            return [];
        }

        $result = [];

        $substrings = [];
        foreach ($this->elements as $element) {
            if ($element instanceof AttributedSubstring) {
                $substrings[] = $element;
                continue;
            }

            if (count($substrings) > 0) {
                $result[] = new AttributedString($substrings);
                $substrings = [];
            }

            $result[] = $element;
        }

        if (count($substrings) > 0) {
            $result[] = new AttributedString($substrings);
        }

        return $result;
    }

    public function withoutAttachments(): AttributedString
    {
        $elements = array_filter($this->elements, function ($element) {
            return !($element instanceof Attachment);
        });

        return new AttributedString(array_values($elements));
    }

    public function withoutAttributes(): AttributedString
    {
        return new self(array_map(fn ($e) => $e->withoutAttributes(), $this->elements));
    }

    /**
     * @param class-string<Attribute>|(Attribute&UnitEnum) $attribute
     */
    public function withoutAttribute(string|Attribute $attribute): AttributedString
    {
        return new self(array_map(fn ($e) => $e->withoutAttribute($attribute), $this->elements));
    }

    /**
     * @param string|(callable(string[] $match, AttributeContainer $attributes): (string|AttributedSubstring|Attachment|AttributedString)) $replace
     * @return self
     */
    public function replace(string $search, string|callable $replace): AttributedString
    {
        $elements = [];

        foreach ($this->elements as $element) {
            if (!($element instanceof AttributedSubstring)) {
                $elements[] = $element;
                continue;
            }

            array_push($elements, ...$element->replace($search, $replace));
        }


        if ($this->elements === $elements) {
            return $this;
        }

        return new self($elements);
    }

    /**
     * @param string|(callable(string[] $match, AttributeContainer $attributes): (string|AttributedSubstring|Attachment|AttributedString)) $replace
     * @return self
     */
    public function replaceMatches(string $regex, string|callable $replace): AttributedString
    {
        $elements = [];

        foreach ($this->elements as $element) {
            if (!($element instanceof AttributedSubstring)) {
                $elements[] = $element;
                continue;
            }

            array_push($elements, ...$element->replaceMatches($regex, $replace));
        }

        if ($this->elements === $elements) {
            return $this;
        }

        return new AttributedString($elements);
    }

    public function __toString(): string
    {
        return new StringEncoder()->encode($this);
    }
}
