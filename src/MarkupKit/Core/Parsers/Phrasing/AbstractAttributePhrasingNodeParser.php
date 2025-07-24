<?php

namespace MarkupKit\Core\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\Parsers\Traits\ParsePhrasingChildNodes;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;

abstract readonly class AbstractAttributePhrasingNodeParser implements PhrasingNodeParser
{
    use ParsePhrasingChildNodes;

    /**
     * @param Context<mixed> $context
     */
    abstract protected function withAttributesForNode(
        DOMElement $node,
        AttributeContainer $attributes,
        Context $context
    ): AttributeContainer;

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
            $this->withAttributesForNode($node, $attributes, $context),
            $context
        );
    }
}
