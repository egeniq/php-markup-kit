<?php

namespace MarkupKit\Standard\String;

use MarkupKit\Core\String\Attribute;
use MarkupKit\Core\String\Encoder\Html\HtmlAttribute;
use MarkupKit\Core\String\Encoder\Markdown\MarkdownAttribute;

enum FormatAttribute implements Attribute, HtmlAttribute, MarkdownAttribute
{
    case Bold;
    case Italic;
    case Underline;

    public function getHtmlOpeningTag(): string
    {
        return match ($this) {
            self::Bold => '<strong>',
            self::Italic => '<em>',
            self::Underline => '<u>',
        };
    }

    public function getHtmlClosingTag(): string
    {
        return match ($this) {
            self::Bold => '</strong>',
            self::Italic => '</em>',
            self::Underline => '</u>',
        };
    }

    public function getMarkdownOpeningMarker(): string
    {
        return match ($this) {
            self::Bold => '**',
            self::Italic => '*',
            self::Underline => '__',
        };
    }

    public function getMarkdownClosingMarker(): string
    {
        return match ($this) {
            self::Bold => '**',
            self::Italic => '*',
            self::Underline => '__',
        };
    }
}
