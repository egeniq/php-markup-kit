<?php

namespace MarkupKit\Core\String;

use MarkupKit\Core\String\Encoder\String\StringEncoder;
use Stringable;

readonly class AttributedString implements Stringable
{
    /**
     * @param array<AttributedSubstring|Attachment> $elements
     */
    public function __construct(
        public array $elements = []
    ) {
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

    public function __toString(): string
    {
        return new StringEncoder()->encode($this);
    }
}
