<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use InvalidArgumentException;
use MarkupKit\Core\Context;
use MarkupKit\Standard\Components\Text\Style;

readonly class HeadingFlowNodeParser extends PhrasingContainerFlowNodeParser
{
    protected function getSupportedTagNames(): array
    {
        return ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
    }

    protected function getStyleForNode(DOMElement $node, Context $context): Style
    {
        return match ($node->tagName) {
            'h1' => Style::Heading1,
            'h2' => Style::Heading2,
            'h3' => Style::Heading3,
            'h4' => Style::Heading4,
            'h5' => Style::Heading5,
            'h6' => Style::Heading6,
            default => throw new InvalidArgumentException("Unsupported heading tag: {$node->tagName}"),
        };
    }
}
