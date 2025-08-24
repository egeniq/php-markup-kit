<?php

namespace MarkupKit\Core\String;

use MarkupKit\Core\String\Internal\Traits\OptimizeElements;
use Stringable;

final readonly class AttributedSubstring extends AbstractAttributedElement implements Stringable
{
    use OptimizeElements;

    /**
     * @param AttributeContainer|array<int, Attribute> $attributes
     */
    public function __construct(
        public string $string,
        AttributeContainer|array $attributes = []
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

    /**
     * @param string|(callable(string[] $match, AttributeContainer $attributes): (string|AttributedSubstring|Attachment|AttributedString)) $replace
     *
     * @return (AttributedSubstring|Attachment)[]
     */
    public function replace(string $search, callable|string $replace): array
    {
        if (is_string($replace)) {
            $string = str_replace($search, $replace, $this->string);
            if ($string === $this->string) {
                return [$this];
            }

            return [new self($string, $this->attributes)];
        }

        return $this->replaceMatches('/' . preg_quote($search, '/') . '/', $replace);
    }

    /**
     * @param string|(callable(string[] $match, AttributeContainer $attributes): (string|AttributedSubstring|Attachment|AttributedString)) $replace
     *
     * @return (AttributedSubstring|Attachment)[]
     */
    public function replaceMatches(string $regex, callable|string $replace): array
    {
        if (is_string($replace)) {
            $string = preg_replace($regex, $replace, $this->string);
            if ($string === null || $string === $this->string) {
                return [$this];
            }

            return [new self($string, $this->attributes)];
        }

        $count = preg_match_all(
            $regex,
            $this->string,
            $matches,
            flags: PREG_OFFSET_CAPTURE
        );

        if ($count === false || $count === 0) {
            return [$this];
        }

        $elements = [];
        $offset = 0;
        foreach ($matches[0] as $i => [$match, $matchOffset]) {
            if ($matchOffset > $offset) {
                $elements[] = new self(
                    substr($this->string, $offset, $matchOffset - $offset),
                    $this->attributes
                );
            }

            $matchData = array_map(fn($sub) => $sub[$i][0], $matches);
            $replacement = $replace($matchData, $this->attributes);

            if (is_string($replacement) && $replacement !== '') {
                $elements[] = new self($replacement, $this->attributes);
            } elseif ($replacement instanceof AttributedSubstring || $replacement instanceof Attachment) {
                $elements[] = $replacement;
            } elseif ($replacement instanceof AttributedString) {
                array_push($elements, ...$replacement->elements);
            }
            // else empty replacement, do nothing

            $offset = (int)$matchOffset + strlen($match);
        }

        if ($offset < strlen($this->string)) {
            $elements[] = new self(
                substr($this->string, $offset),
                $this->attributes
            );
        }

        return $this->optimizeElements($elements);
    }
}
