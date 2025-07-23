<?php

namespace MarkupKit\Core\String\Encoder\Markdown;

use MarkupKit\Core\String\Attribute;

interface MarkdownAttribute extends Attribute
{
    public function getMarkdownOpeningMarker(): string;
    public function getMarkdownClosingMarker(): string;
}
