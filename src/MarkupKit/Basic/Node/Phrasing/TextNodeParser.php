<?php

namespace MarkupKit\Basic\Node\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Parser;

readonly class TextNodeParser implements PhrasingNodeParser
{
    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        return $node instanceof DOMText;
    }

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Parser $parser
    ): void {
        assert($node instanceof DOMText);

        if (!is_string($node->nodeValue) || $node->nodeValue === '') {
            return;
        }

        $stringBuilder->appendString($node->nodeValue, $attributes);
    }
}
