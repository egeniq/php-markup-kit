<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use MarkupKit\Core\Context;
use MarkupKit\Standard\Components\Text\Style;

readonly class QuoteFlowNodeParser extends PhrasingContainerFlowNodeParser
{
    protected function getSupportedTagNames(): array
    {
        return ['blockquote', 'q'];
    }

    protected function getStyleForNode(DOMElement $node, Context $context): Style
    {
        return Style::Quote;
    }
}
