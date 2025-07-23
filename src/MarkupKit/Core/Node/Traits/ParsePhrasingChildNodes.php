<?php

namespace MarkupKit\Core\Node\Traits;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Parser;

trait ParsePhrasingChildNodes
{
    /**
     * @param Parser<mixed> $parser
     */
    protected function parsePhrasingChildNodes(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Parser $parser
    ): void {
        foreach ($node->childNodes as $childNode) {
            if ($childNode instanceof DOMElement || $childNode instanceof DOMText) {
                $parser->parsePhrasingNode($childNode, $stringBuilder, $attributes);
            }
        }
    }
}
