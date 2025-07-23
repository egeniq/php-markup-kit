<?php

namespace MarkupKit\Basic\Node\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Basic\String\LinkAttribute;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Node\Traits\ParsePhrasingChildNodes;
use MarkupKit\Core\Parser;

readonly class LinkNodeParser implements PhrasingNodeParser
{
    use ParsePhrasingChildNodes;

    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        return $node instanceof DOMElement && $node->tagName === 'a';
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
            $attributes->withAttribute(new LinkAttribute($node->getAttribute('href'))),
            $parser
        );
    }
}
