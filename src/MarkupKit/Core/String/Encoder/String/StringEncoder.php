<?php

namespace MarkupKit\Core\String\Encoder\String;

use MarkupKit\Core\String\AttributedElement;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\Encoder\Encoder;
use Stringable;

readonly class StringEncoder implements Encoder
{
    protected function encodeElement(AttributedElement $element): string|AttributedElement
    {
        if ($element instanceof Stringable) {
            return (string)$element;
        }

        return $element;
    }

    /**
     * @param array<string|AttributedElement> $elements
     */
    protected function joinWithSpaces(array $elements): string
    {
        $result = '';
        $endsWithSpace = false;

        $elements = array_filter($elements, fn ($element) => !is_string($element) || strlen($element) > 0);

        foreach ($elements as $i => $element) {
            if (is_string($element)) {
                $result .= $element;
                $endsWithSpace = preg_match('/\s$/', $element);
                continue;
            }

            // attachment that is not encodable as a string

            // current result already ending with a space, no need to add another one
            if ($result === '' || $endsWithSpace) {
                continue;
            }

            // find the next element that has been encoded as a string
            $nextSubstring = null;
            for ($j = $i + 1; $j < count($elements); $j++) {
                if (is_string($elements[$j])) {
                    $nextSubstring = $elements[$j];
                    break;
                }
            }

            // if the found string starts with a space, we don't need to another space
            if ($nextSubstring === null || preg_match('/^\s/', $nextSubstring)) {
                continue;
            }

            $result .= ' ';
        }

        return $result;
    }

    public function encode(AttributedString $string): string
    {
        $parts = [];
        foreach ($string->elements as $i => $element) {
            $parts[] = $this->encodeElement($element);
        }

        return $this->joinWithSpaces($parts);
    }
}
