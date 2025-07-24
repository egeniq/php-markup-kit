<?php

namespace MarkupKit\Standard\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Standard\String\FormatAttribute;
use MarkupKit\Core\Parsers\Phrasing\AbstractAttributePhrasingNodeParser;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;

readonly class FormatAttributePhrasingNodeParser extends AbstractAttributePhrasingNodeParser
{
    /**
 * @param Context<mixed> $context
 */
    public function isPhrasingNodeSupported(DOMElement|DOMText $node, Context $context): bool
    {
        return $node instanceof DOMElement && in_array($node->tagName, ['strong', 'b', 'em', 'i', 'u'], true);
    }

    protected function withAttributesForNode(
        DOMElement $node,
        AttributeContainer $attributes,
        Context $context
    ): AttributeContainer {
        return match ($node->tagName) {
            'strong', 'b' => $attributes->withAttribute(FormatAttribute::Bold),
            'em', 'i' => $attributes->withAttribute(FormatAttribute::Italic),
            'u' => $attributes->withAttribute(FormatAttribute::Underline),
            default => $attributes
        };
    }
}
