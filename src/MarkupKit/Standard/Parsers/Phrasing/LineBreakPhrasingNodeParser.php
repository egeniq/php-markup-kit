<?php

namespace MarkupKit\Standard\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;

readonly class LineBreakPhrasingNodeParser implements PhrasingNodeParser
{
    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        return $node instanceof DOMElement && $node->tagName === 'br';
    }

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void {
        assert($node instanceof DOMElement);
        $stringBuilder->appendLineBreak($attributes);
    }
}
