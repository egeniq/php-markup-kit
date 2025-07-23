<?php

namespace MarkupKit\Basic\Node\Flow;

use DOMElement;
use MarkupKit\Basic\Components\Text\Style;

readonly class QuoteNodeParser extends PhrasingContainerFlowNodeParser
{
    protected function getSupportedTagNames(): array
    {
        return ['blockquote', 'q'];
    }

    protected function getStyleForNode(DOMElement $node): Style
    {
        return Style::Quote;
    }
}
