<?php

namespace MarkupKit\Core\String\Encoder\Markdown;

use MarkupKit\Core\String\AttributedElement;

interface MarkdownElement extends AttributedElement
{
    public function getMarkdown(): string;
}
