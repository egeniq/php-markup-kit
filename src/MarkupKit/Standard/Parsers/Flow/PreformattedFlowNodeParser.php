<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use MarkupKit\Core\Context;
use MarkupKit\Standard\Components\Text\Style;

readonly class PreformattedFlowNodeParser extends PhrasingContainerFlowNodeParser
{
    protected function getSupportedTagNames(): array
    {
        return ['pre', 'code'];
    }

    protected function getStyleForNode(DOMElement $node): Style
    {
        return Style::Preformatted;
    }

    protected function getPreserveWhitespaceForNode(DOMElement $node, Context $context): bool
    {
        return true;
    }
}
