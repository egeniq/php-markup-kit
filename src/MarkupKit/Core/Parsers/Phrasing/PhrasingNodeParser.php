<?php

namespace MarkupKit\Core\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Context;

interface PhrasingNodeParser
{
    /**
 * @param Context<mixed> $context
 */
    public function isPhrasingNodeSupported(DOMElement|DOMText $node, Context $context): bool;

    /**
     * @param Context<mixed> $context
     */
    public function parsePhrasingNode(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void;
}
