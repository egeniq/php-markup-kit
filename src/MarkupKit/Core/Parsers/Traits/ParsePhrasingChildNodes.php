<?php

namespace MarkupKit\Core\Parsers\Traits;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Context;

trait ParsePhrasingChildNodes
{
    /**
     * @param Context<mixed> $context
     */
    protected function parsePhrasingChildNodes(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void {
        foreach ($node->childNodes as $childNode) {
            if ($childNode instanceof DOMElement || $childNode instanceof DOMText) {
                $context->parsePhrasingNode($childNode, $stringBuilder, $attributes);
            }
        }
    }
}
