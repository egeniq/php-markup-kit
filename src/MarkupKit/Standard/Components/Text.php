<?php

namespace MarkupKit\Standard\Components;

use MarkupKit\Standard\Components\Text\Style;
use MarkupKit\Core\String\AttributedString;

readonly class Text implements Component
{
    public function __construct(
        public AttributedString $content,
        public Style $style = Style::Body
    ) {
    }
}
