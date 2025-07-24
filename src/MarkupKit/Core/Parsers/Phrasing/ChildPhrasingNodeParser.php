<?php

namespace MarkupKit\Core\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\Parsers\Traits\ParsePhrasingChildNodes;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;

readonly class ChildPhrasingNodeParser implements PhrasingNodeParser
{
    use ParsePhrasingChildNodes;

    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        return $node instanceof DOMElement;
    }

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void {
        assert($node instanceof DOMElement);

        $this->parsePhrasingChildNodes(
            $node,
            $stringBuilder,
            $attributes,
            $context
        );
    }
}
