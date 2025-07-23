<?php

namespace MarkupKit\Basic\Components;

use MarkupKit\Basic\Components\Text\Style;
use MarkupKit\Core\String\AttributedString;

readonly class Text implements Component
{
    public function __construct(
        public AttributedString $string,
        public Style $style = Style::Body
    ) {
    }
}
