<?php

namespace MarkupKit\Standard\String;

use MarkupKit\Core\String\Encoder\Html\HtmlAttribute;
use MarkupKit\Core\String\Encoder\Markdown\MarkdownAttribute;
use MarkupKit\Core\String\UniqueAttribute;

readonly class LinkAttribute implements UniqueAttribute, HtmlAttribute, MarkdownAttribute
{
    public function __construct(
        public string $url
    ) {
    }

    public function getHtmlOpeningTag(): string
    {
        return '<a href="' . htmlspecialchars($this->url, ENT_QUOTES) . '">';
    }

    public function getHtmlClosingTag(): string
    {
        return '</a>';
    }

    public function getMarkdownOpeningMarker(): string
    {
        return '[';
    }

    public function getMarkdownClosingMarker(): string
    {
        return '](' . htmlspecialchars($this->url, ENT_QUOTES) . ')';
    }
}
