<?php

namespace MarkupKit\Core\String;

class AttributedStringBuilder
{
    /**
     * @var array<AttributedSubstring|Attachment>
     */
    private array $elements = [];

    /**
     * @param bool $preserveWhitespace Whether to preserve whitespace in the string. Setting this to false will normalize whitespace.
     * @param bool $trimWhitespaceAroundAttachments Whether to trim whitespace around attachments.
     */
    public function __construct(
        public readonly bool $preserveWhitespace = false,
        public readonly bool $trimWhitespaceAroundAttachments = false
    ) {
    }

    private function startsWithWhitespace(string $string): bool
    {
        return preg_match('/^\s/', $string) === 1;
    }

    private function endsWithWhitespace(string $string): bool
    {
        return preg_match('/\s$/', $string) === 1;
    }

    private function isLineBreak(string $string): bool
    {
        return $string === "\n";
    }

    private function normalizeSpace(string $string, ?AbstractAttributedElement $previousElement): string
    {
        if ($this->preserveWhitespace) {
            return $string;
        }

        // Replace multiple spaces with a single space
        // NOTE: non-breaking spaces (chr(160)) are preserved
        $result = preg_replace('/\s+/', ' ', $string) ?? $string;

        if (!$this->startsWithWhitespace($result)) {
            return $result;
        }

        // Normalize leading whitespace
        $result = ltrim($result);

        if (
            ($previousElement instanceof AttributedSubstring) &&
            ($this->isLineBreak($previousElement->string) || !$this->endsWithWhitespace($previousElement->string))
        ) {
            $result = ' ' . $result;
        } elseif (
            $previousElement instanceof Attachment && !$this->trimWhitespaceAroundAttachments
        ) {
            $result = ' ' . $result;
        }

        // NOTE:
        // We do not trim trailing whitespace here, because we don't know if there
        // will be another element after this one.

        return $result;
    }

    /**
     * @return array<AttributedSubstring|Attachment>
     */
    private function normalizeTrailingSpace(): array
    {
        $elements = $this->elements;

        if ($this->preserveWhitespace || count($elements) === 0) {
            return $elements;
        }

        for ($i = count($elements) - 1; $i >= 0; $i--) {
            $element = $elements[$i];

            if (
                !($element instanceof AttributedSubstring) ||
                $this->isLineBreak($element->string) ||
                !$this->endsWithWhitespace($element->string)
            ) {
                break;
            }

            $content = rtrim($element->string);

            if (strlen($content) > 0) {
                $elements[$i] = new AttributedSubstring($content, $element->attributes);
                break;
            }

            array_pop($elements);
        }

        return $elements;
    }

    public function appendString(string $string, AttributeContainer $attributes): void
    {
        $string = $this->normalizeSpace($string, end($this->elements) ?: null);
        if (strlen($string) === 0) {
            return;
        }

        $this->elements[] = new AttributedSubstring($string, $attributes);
    }

    public function appendLineBreak(AttributeContainer $attributes): void
    {
        $this->elements[] = new AttributedSubstring("\n", $attributes);
    }

    public function appendAttachment(Attachment $attachment): void
    {
        if (!$this->trimWhitespaceAroundAttachments) {
            $this->elements[] = $attachment;
            return;
        }

        $this->elements = [
            ...$this->normalizeTrailingSpace(),
            $attachment
        ];
    }

    public function isEmpty(): bool
    {
        return count($this->elements) === 0;
    }

    public function build(): AttributedString
    {
        return new AttributedString($this->normalizeTrailingSpace());
    }
}
