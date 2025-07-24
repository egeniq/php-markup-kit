<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use MarkupKit\Standard\Components\Text\Style;

readonly class QuoteFlowNodeParser extends PhrasingContainerFlowNodeParser
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
