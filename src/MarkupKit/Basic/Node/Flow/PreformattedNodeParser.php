<?php

namespace MarkupKit\Basic\Node\Flow;

use DOMElement;
use MarkupKit\Basic\Components\Text\Style;

readonly class PreformattedNodeParser extends PhrasingContainerFlowNodeParser
{
    protected function getSupportedTagNames(): array
    {
        return ['pre', 'code'];
    }

    protected function getStyleForNode(DOMElement $node): Style
    {
        return Style::Preformatted;
    }

    protected function getPreserveWhitespaceForNode(DOMElement $node): bool
    {
        return true;
    }
}
