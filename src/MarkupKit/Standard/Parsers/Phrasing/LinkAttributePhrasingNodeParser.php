<?php

namespace MarkupKit\Standard\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Standard\String\LinkAttribute;
use MarkupKit\Core\Parsers\Phrasing\AbstractAttributePhrasingNodeParser;
use MarkupKit\Core\Parsers\Traits\ParsePhrasingChildNodes;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;

readonly class LinkAttributePhrasingNodeParser extends AbstractAttributePhrasingNodeParser
{
    use ParsePhrasingChildNodes;

    /**
 * @param Context<mixed> $context
 */
    public function isPhrasingNodeSupported(DOMElement|DOMText $node, Context $context): bool
    {
        return $node instanceof DOMElement && $node->tagName === 'a';
    }

    protected function withAttributesForNode(
        DOMElement $node,
        AttributeContainer $attributes,
        Context $context
    ): AttributeContainer {
        return $attributes->withAttribute(
            new LinkAttribute($node->getAttribute('href'))
        );
    }
}
