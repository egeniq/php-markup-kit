<?php

namespace MarkupKit\Core\String\Encoder\Markdown;

use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AbstractAttributedElement;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedSubstring;
use MarkupKit\Core\String\Encoder\Encoder;

class MarkdownEncoder implements Encoder
{
    protected function openAttributes(AttributeContainer $attributes): string
    {
        $result = '';

        foreach ($attributes as $attribute) {
            if ($attribute instanceof MarkdownAttribute) {
                $result .= $attribute->getMarkdownOpeningMarker();
            }
        }

        return $result;
    }

    protected function closeAttributes(AttributeContainer $attributes): string
    {
        $result = '';

        foreach ($attributes->reversed() as $attribute) {
            if ($attribute instanceof MarkdownAttribute) {
                $result .= $attribute->getMarkdownClosingMarker();
            }
        }

        return $result;
    }

    protected function encodeElement(AbstractAttributedElement $element): string
    {
        if ($element instanceof AttributedSubstring) {
            return (string)$element;
        }

        if ($element instanceof MarkdownElement) {
            return $element->getMarkdown();
        }

        return '';
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function splitTrailingWhitespace(string $text): array
    {
        if (preg_match('/\s+$/', $text, $matches)) {
            $trailingSpaces = $matches[0];
            return [substr($text, 0, -strlen($trailingSpaces)), $trailingSpaces];
        }

        return [$text, ''];
    }

    public function encode(AttributedString $string): string
    {
        $result = '';

        $previous = null;
        foreach ($string->elements as $current) {
            if ($current instanceof AttributedSubstring && $current->string === "\n") {
                if ($previous !== null) {
                    $result .= $this->closeAttributes($previous->attributes);
                }

                $result .= "\n";

                $previous = null;
                continue;
            }

            $attrsToClose = $previous === null ? new AttributeContainer() : $previous->attributes->diff($current->attributes);
            if (!$attrsToClose->isEmpty()) {
                [$result, $trailingWhitespace] = $this->splitTrailingWhitespace($result);
                $result .= $this->closeAttributes($attrsToClose) . $trailingWhitespace;
            }

            $attrsToOpen = $previous === null ? $current->attributes : $current->attributes->diff($previous->attributes);
            $result .= $this->openAttributes($attrsToOpen);

            $result .= $this->encodeElement($current);

            $previous = $current;
        }

        if ($previous !== null && !$previous->attributes->isEmpty()) {
            [$result, $trailingWhitespace] = $this->splitTrailingWhitespace($result);
            $result .= $this->closeAttributes($previous->attributes) . $trailingWhitespace;
        }

        return $result;
    }
}
