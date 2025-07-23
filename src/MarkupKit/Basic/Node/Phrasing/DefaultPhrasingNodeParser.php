<?php

namespace MarkupKit\Basic\Node\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Node\Traits\ParsePhrasingChildNodes;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;

readonly class DefaultPhrasingNodeParser implements PhrasingNodeParser
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
        Parser $parser
    ): void {
        assert($node instanceof DOMElement);

        $this->parsePhrasingChildNodes(
            $node,
            $stringBuilder,
            $attributes,
            $parser
        );
    }
}
