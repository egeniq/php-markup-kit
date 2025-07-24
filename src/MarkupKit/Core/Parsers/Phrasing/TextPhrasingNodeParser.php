<?php

namespace MarkupKit\Core\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;

readonly class TextPhrasingNodeParser implements PhrasingNodeParser
{
    /**
 * @param Context<mixed> $context
 */
    public function isPhrasingNodeSupported(DOMElement|DOMText $node, Context $context): bool
    {
        return $node instanceof DOMText;
    }

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void {
        assert($node instanceof DOMText);

        if (!is_string($node->nodeValue) || $node->nodeValue === '') {
            return;
        }

        $stringBuilder->appendString($node->nodeValue, $attributes);
    }
}
